<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = ['name', 'region_id', 'description', 'address'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
