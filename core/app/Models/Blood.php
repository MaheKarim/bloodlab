<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    use GlobalStatus;
    public function donor()
    {
        return $this->hasMany(Donor::class);
    }
}
