<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->family) {
            return view('dashboard');
        }

        $familyId = $user->family_id;

        // Statistiche principali
        $totalIncome = Transaction::where('family_id', $familyId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = Transaction::where('family_id', $familyId)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpenses;
        $membersCount = $user->family->users()->count();

        // Transazioni recenti
        $recentTransactions = Transaction::with('user')
            ->where('family_id', $familyId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Dati per grafico mensile
        $monthlyData = Transaction::where('family_id', $familyId)
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, type, SUM(amount) as total')
            ->groupBy('year', 'month', 'type')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $monthlyLabels = [];
        $monthlyIncome = [];
        $monthlyExpenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $income = $monthlyData->where('year', $date->year)
                ->where('month', $date->month)
                ->where('type', 'income')
                ->first();

            $expense = $monthlyData->where('year', $date->year)
                ->where('month', $date->month)
                ->where('type', 'expense')
                ->first();

            $monthlyIncome[] = $income ? $income->total : 0;
            $monthlyExpenses[] = $expense ? $expense->total : 0;
        }

        // Dati per categorie
        $categoryData = Transaction::where('family_id', $familyId)
            ->where('type', 'expense')
            ->whereNotNull('category')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get();

        $categoryLabels = $categoryData->pluck('category')->toArray();
        $categoryValues = $categoryData->pluck('total')->toArray();

        // Spese per membro (ultimi 30 giorni)
        $memberData = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
            ->where('transactions.family_id', $familyId)
            ->where('transactions.type', 'expense')
            ->where('transactions.date', '>=', now()->subDays(30))
            ->selectRaw('users.name, SUM(transactions.amount) as total')
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->get();

        $memberLabels = $memberData->pluck('name')->toArray();
        $memberTotals = $memberData->pluck('total')->toArray();

        // Dati cumulativi annuali
        $cumulativeData = Transaction::where('family_id', $familyId)
            ->whereYear('date', date('Y'))
            ->selectRaw('MONTH(date) as month, 
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $cumulativeLabels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'];
        $cumulativeValues = array_fill(0, 12, 0);
        $currentBalance = 0;

        foreach ($cumulativeData as $data) {
            $monthIndex = $data->month - 1;
            $monthBalance = $data->income - $data->expense;
            $currentBalance += $monthBalance;
            $cumulativeValues[$monthIndex] = $currentBalance;
        }

        // Fill remaining months with current balance
        for ($i = 0; $i < 12; $i++) {
            if ($cumulativeValues[$i] === 0 && $i > 0) {
                $cumulativeValues[$i] = $cumulativeValues[$i - 1];
            }
        }

        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'membersCount',
            'recentTransactions',
            'monthlyLabels',
            'monthlyIncome',
            'monthlyExpenses',
            'categoryLabels',
            'categoryValues',
            'memberLabels',
            'memberTotals',
            'cumulativeLabels',
            'cumulativeValues'
        ));
    }
}
