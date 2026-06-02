<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityBooking extends Model
{
    protected $fillable = [
        'facility_id',
        'tenant_id',
        'booking_date',
        'start_time',
        'end_time',
        'guest_count',
        'status',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}
