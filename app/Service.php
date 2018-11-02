<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function scopeByName($query, $serviceName)
    {
        return $query->where('name', strtolower($serviceName));
    }
}
