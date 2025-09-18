<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $family = $user->family;

        return view('user.family.index', compact('family'));
    }

    public function create()
    {
        return view('user.family.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $family = Family::create([
            'name' => $request->name,
            'code' => Str::random(8),
        ]);

        Auth::user()->update(['family_id' => $family->id]);

        return redirect()->route('user.family.index')
            ->with('success', 'Famiglia creata con successo! Codice: ' . $family->code);
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:families,code',
        ]);

        $family = Family::where('code', $request->code)->first();

        if ($family) {
            Auth::user()->update(['family_id' => $family->id]);
            return redirect()->route('user.family.index')
                ->with('success', 'Ti sei unito alla famiglia ' . $family->name);
        }

        return back()->with('error', 'Codice famiglia non valido');
    }

    public function update(Request $request, Family $family)
    {
        // Verifica che l'utente appartenga alla famiglia
        if (Auth::user()->family_id !== $family->id) {
            abort(403, 'Non autorizzato');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $family->update(['name' => $request->name]);

        return redirect()->route('user.family.index')
            ->with('success', 'Nome famiglia aggiornato con successo');
    }

    public function leave(Family $family)
    {
        // Verifica che l'utente appartenga alla famiglia
        if (Auth::user()->family_id !== $family->id) {
            abort(403, 'Non autorizzato');
        }

        Auth::user()->update(['family_id' => null]);

        // Se non ci sono più membri, elimina la famiglia
        if ($family->users()->count() === 0) {
            $family->delete();
        }

        return redirect()->route('user.family.index')
            ->with('success', 'Hai lasciato la famiglia');
    }

    public function acceptInvite($token)
    {
        // Implementazione semplice per gli inviti
        // In una versione completa, qui verificheresti il token nel database
        $family = Family::where('code', $token)->first();

        if ($family && Auth::check()) {
            Auth::user()->update(['family_id' => $family->id]);
            return redirect()->route('user.family.index')
                ->with('success', 'Ti sei unito alla famiglia ' . $family->name);
        }

        return redirect()->route('login')->with('error', 'Invito non valido o scaduto');
    }
}
