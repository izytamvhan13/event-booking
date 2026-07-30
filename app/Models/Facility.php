<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $guarded = [];

    public function venues()
    {
        return $this->belongsToMany(Venue::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }
}