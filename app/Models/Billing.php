<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'unit_id',
        'amount',
        'admin_fee',
        'platform_fee',
        'fine_amount',
        'paid_amount',
        'period',
        'due_date',
        'status',
        'last_reminded_at',
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
