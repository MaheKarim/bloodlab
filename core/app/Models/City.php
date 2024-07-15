<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use GlobalStatus;
    public function location()
    {
        return $this->hasMany(Location::class);
    }
}
