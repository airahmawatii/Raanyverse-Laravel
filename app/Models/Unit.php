<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'blok',
        'nomor_unit',
        'type',
        'property_type',
        'price',
        'image',
        'status',
        'estate_id',
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
