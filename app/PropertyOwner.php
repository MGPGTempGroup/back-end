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

    public function setAddressAttribute($val)
    {
        $this->attributes['address'] = json_encode($val);
    }

    public function getAddressAttribute($val)
    {
        return json_decode($val);
    }

    /**
     * 备注关联关系
     */
    public function remarks()
    {
        return $this->morphMany(Remark::class, 'come_from');
    }

}
