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

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    /**
     * 备注关联关系
     */
    public function remarks()
    {
        return $this->morphMany('App\Remark', 'come_from');
    }

}
