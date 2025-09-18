<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{
    public function index(Family $family)
    {
        // Verifica che l'utente appartenga alla famiglia
        if (Auth::user()->family_id !== $family->id) {
            abort(403, 'Non autorizzato');
        }

        $members = $family->users;
        return view('user.family.members', compact('family', 'members'));
    }

    public function removeMember(Family $family, User $user)
    {
        // Verifica che l'utente appartenga alla famiglia e non stia cercando di rimuovere se stesso
        if (Auth::user()->family_id !== $family->id) {
            abort(403, 'Non autorizzato');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Non puoi rimuovere te stesso. Usa "Lascia Famiglia" invece.');
        }

        $user->update(['family_id' => null]);

        return redirect()->back()
            ->with('success', 'Membro rimosso dalla famiglia');
    }
}
