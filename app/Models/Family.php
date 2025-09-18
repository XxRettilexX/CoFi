<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    // Aggiungi le proprietà che possono essere assegnate in massa
    protected $fillable = [
        'name',
        'code',
    ];

    // Relazione con gli utenti
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
