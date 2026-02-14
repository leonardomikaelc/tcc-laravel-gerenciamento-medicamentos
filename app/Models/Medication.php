<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dosage',
        'batch',
        'expiration_date',
        'presentation',
        'quantity',
        'controlled',
        'available_for_donation',
        'donation_date',
        'donation_destination'
    ];

    protected $casts = [
        'controlled' => 'boolean',
        'available_for_donation' => 'boolean',
        'expiration_date' => 'date',
        'donation_date' => 'date'
    ];
}
