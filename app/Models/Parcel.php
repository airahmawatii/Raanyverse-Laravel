<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'recipient_name',
        'unit_id',
        'courier_name',
        'tracking_number',
        'status',
        'received_at',
        'taken_at'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
