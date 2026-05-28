<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'interested_unit_id',
        'status',
        'survey_date',
        'notes'
    ];

    public function interestedUnit()
    {
        return $this->belongsTo(Unit::class, 'interested_unit_id');
    }
}
