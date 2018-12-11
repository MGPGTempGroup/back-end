<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class residence extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'brief_introduction',
        'floor_space',
        'details',
        'broadcast_pictures',
        'country_code',
        'state_code',
        'city_code',
        'suburb_name',
        'street_name',
        'street_code',
        'house_number',
        'post_code',
        'address',
        'address_description',
        'map_coordinates',
        'bathrooms',
        'bedrooms',
        'car_spaces',
        'lockup_garages',
        'min_price',
        'pv',
        'max_price',
        'upcoming_inspections_start_time',
        'upcoming_inspections_end_time',
        'available_start_date',
        'available_end_date',
        'constructed_in',
        'built_in',
        'sort_number',
        'show',
        'is_new_development',
        'state',
        'owner_id',
        'uv',
        'information_statement',
        'video_embedded_code'
    ];

    protected $casts = [
        'bathrooms' => 'int',
        'bedrooms' => 'int',
        'car_spaces' => 'int',
        'lockup_garages' => 'int',
        'show' => 'int',
        'sort_number' => 'int',
        'property_type_id' => 'int',
        'max_price' => 'int',
        'min_price' => 'int'
    ];

    protected $attributes = [
        'bathrooms' => 0,
        'bedrooms' => 0,
        'car_spaces' => 0,
        'lockup_garages' => 0,
        'pv' => 0,
        'uv' => 0,
        'show' => 1,
        'sort_number' => 0,
    ];

    public function setBroadcastPicturesAttribute($val)
    {
        return $this->attributes['broadcast_pictures'] = json_encode($val);
    }

    public function getBroadcastPicturesAttribute($val)
    {
        return json_decode($val);
    }

    public function getAddressAttribute($address)
    {
        return json_decode($address);
    }

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = json_encode($address);
    }

    /**
     * 物业拥有者关联关系
     */
    public function owner()
    {
        return $this->belongsTo(PropertyOwner::class, 'owner_id', 'id');
    }

    /**
     * 数据创建者关联关系
     */
    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'creator_id', 'id');
    }

    /**
     * 公司成员代理关联关系
     */
    public function agents()
    {
        return $this->belongsToMany(
            CompanyMember::class ,
            'residence_agent',
            'residence_id',
            'member_id')->withTimestamps();
    }

    /**
     * 物业类型关联关系
     */
    public function propertyType()
    {
        return $this->belongsToMany(
            PropertyType::class,
            'residence_property_type',
            'residence_id',
            'property_type_id')->withTimestamps();
    }

    /**
     * 房屋备注关联关系
     */
    public function remarks()
    {
        return $this->hasMany(ResidenceRemark::class, 'residence_id', 'id');
    }

    /**
     * 预约相关关联关系
     */
    public function inspections()
    {
        return $this->morphMany(HouseInspection::class, 'house');
    }

}
