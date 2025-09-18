<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FamilyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Creazione codice unico per la famiglia
        $code = strtoupper(Str::random(8));

        $family = Family::create([
            'name' => $request->name,
            'code' => $code,
        ]);

        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            $user->family_id = $family->id;
            $user->save();
        }
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Famiglia creata con successo!');
    }
}
