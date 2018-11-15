<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyOwner extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'surname', 'email', 'phone', 'wechat', 'identity_id', 'address', 'id_card'];

    public function identity()
    {
        return $this->belongsTo(CustomerIdentity::class, 'identity_id', 'id');
    }
}
