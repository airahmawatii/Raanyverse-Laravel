<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityBooking extends Model
{
    protected $fillable = [
        'facility_id',
        'booked_by',
        'booking_date',
        'start_time',
        'end_time',
        'total_fee',
        'status'
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
}
