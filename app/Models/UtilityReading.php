<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityReading extends Model
{
    protected $fillable = [
        'unit_id',
        'utility_type',
        'reading_value',
        'reading_date',
        'recorded_by'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
