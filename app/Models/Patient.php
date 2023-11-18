<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'age',
        'poids',
        'allergie',
        'taille',
        'sys',
        'dias',
        'adresse',
        'userId'
    ];
}
