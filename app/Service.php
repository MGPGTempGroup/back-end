<?php

namespace App;

use Faker\Provider\Company;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

//    protected $fillable = ['content', 'broadcast_pictures'];

    /**
     * 服务留言关联关系
     */
    public function messages()
    {
        return $this->hasMany(ServiceMessage::class, 'service_id', 'id');
    }

    /**
     * 服务内容关联关系
     */
    public function content()
    {
        return $this->hasOne(ServiceContent::class, 'service_id', 'id')->latest();
    }

    /**
     * 历史服务内容关联关系
     */
    public function historicalContents()
    {
        return $this->hasMany(ServiceContent::class, 'service_id', 'id');
    }

    /**
     * 服务联系成员关联关系
     */
    public function members()
    {
        return $this->belongsToMany(
            CompanyMember::class,
            'service_member',
            'service_id',
            'member_id')->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

}
