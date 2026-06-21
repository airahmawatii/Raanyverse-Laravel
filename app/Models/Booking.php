<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'ktp_url',
        'status',
        'payment_type',
        'duration_months',
        'dp_amount',
        'due_day',
        'google_calendar_event_id',
        'is_synced'
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
