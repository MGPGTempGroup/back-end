<?php

namespace App;

use Faker\Provider\Company;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['content', 'broadcast_pictures'];

    public function scopeByName($query, $serviceName)
    {
        return $query->where('name', strtolower($serviceName));
    }

    /**
     * 服务留言关联关系
     */
    public function messages()
    {
        return $this->hasMany(ServiceMessage::class, 'service_id', 'id');
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
