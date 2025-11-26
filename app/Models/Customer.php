<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'notes',
    ];

    /**
     * RELATIONSHIP: Customer has many Reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
