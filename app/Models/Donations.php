<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'user_id',
        'medication_id',
        'donor_name',
        'quantity',
        'donation_date',
        'status',
    ];

    protected $dates = ['donation_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }
}
