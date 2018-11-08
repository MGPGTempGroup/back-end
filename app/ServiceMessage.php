<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceMessage extends Model
{
    public function identity()
    {
        return $this->belongsTo(CustomerIdentity::class, 'identity_id', 'id');
    }
}
