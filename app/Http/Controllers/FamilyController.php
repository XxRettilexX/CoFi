<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Illuminate\Support\Str;


class FamilyController extends Controller
{
    public function create(Request $request)
    {
        $family = Family::create([
            'name' => $request->name,
            'family_code' => Str::random(10),
        ]);

        return response()->json($family);
    }
}
