<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Se non ha famiglia, reindirizza alla dashboard con form per crearla
        if (!$user->family) {
            return view('dashboard', [
                'family' => null
            ]);
        }

        $family_id = $user->family->id;

        // Totale entrate e uscite
        $totalIncome = Transaction::where('family_id', $family_id)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = Transaction::where('family_id', $family_id)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpenses;

        // Ultime 5 transazioni
        $recentTransactions = Transaction::where('family_id', $family_id)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Grafico mensile
        $monthlyLabels = [];
        $monthlyIncome = [];
        $monthlyExpenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');

            $monthlyIncome[] = Transaction::where('family_id', $family_id)
                ->where('type', 'income')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $monthlyExpenses[] = Transaction::where('family_id', $family_id)
                ->where('type', 'expense')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');
        }

        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'recentTransactions',
            'monthlyLabels',
            'monthlyIncome',
            'monthlyExpenses'
        ));
    }
}
