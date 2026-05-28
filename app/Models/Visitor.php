<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'vehicle_number',
        'unit_id',
        'purpose',
        'check_in_at',
        'check_out_at',
        'status'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
