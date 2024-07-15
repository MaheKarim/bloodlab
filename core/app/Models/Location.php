<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
