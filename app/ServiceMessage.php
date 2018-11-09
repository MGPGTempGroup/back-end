<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceMessage extends Model
{

    use SoftDeletes;

    public function identity()
    {
        return $this->belongsTo(CustomerIdentity::class, 'identity_id', 'id');
    }
}
