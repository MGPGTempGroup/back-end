<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceContent extends Model
{
    protected $fillable = [
        'content',
        'broadcast_pictures'
    ];

    protected $attributes = [
        'broadcast_pictures' => '[]'
    ];

    public function setBroadcastPicturesAttribute($value)
    {
        return $this->attributes['broadcast_pictures'] = json_encode($value);
    }

    public function getBroadcastPicturesAttribute($value)
    {
        return json_decode($value);
    }

    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'creator_id', 'id');
    }

    public function modifier()
    {
        return $this->belongsTo(AdminUser::class, 'modifier_id', 'id');
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
            'member_id',
            'service_id'
        )->withTimestamps();
    }

}
