<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'estate_id',
        'name',
        'description',
        'open_time',
        'close_time',
        'is_bookable',
        'max_capacity',
        'booking_fee'
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
