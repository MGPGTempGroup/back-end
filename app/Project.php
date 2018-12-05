<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'address',
        'status',
        'introduction',
        'description',
        'year_built',
        'is_new_development',
        'is_past_success',
        'min_price',
        'max_price',
        'broadcast_pictures'
    ];

    /**
     * 项目产品类型关联关系
     */
    public function productTypes() {
        return $this->belongsToMany(
            ProductType::class,
            'project_product_type',
            'project_id',
            'product_type_id')->withTimestamps();
    }

    /**
     * 项目代理关联关系
     */
    public function agents()
    {
        return $this->belongsToMany(
            CompanyMember::class,
            'project_agent',
            'project_id',
            'member_id')->withTimestamps();
    }

    /**
     * 数据创建者关联关系
     */
    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'creator_id', 'id');
    }

    public function getAddressAttribute($address)
    {
        return json_decode($address);
    }

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = json_encode($address);
    }

    public function getBroadcastPicturesAttribute($broadcastPictures)
    {
        return json_decode($broadcastPictures);
    }

    public function setBroadcastPicturesAttribute($broadcastPictures)
    {
        $this->attributes['broadcast_pictures'] = json_encode($broadcastPictures);
    }

}
