<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'motif',
        'date_consultation',
        'patientId',
        'medecinId',
        'status',
        'rapport',
    ];
}
