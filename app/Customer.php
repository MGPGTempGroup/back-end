<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'surname', 'email', 'phone', 'wechat', 'address', 'customer_identity_id'];

    public function identity()
    {
        return $this->belongsTo(CustomerIdentity::class, 'customer_identity_id', 'id');
    }

}
