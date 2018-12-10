<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lease extends Model
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
        'area_name',
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
        'per_month_min_price',
        'per_month_max_price',
        'per_week_min_price',
        'per_week_max_price',
        'per_day_min_price',
        'per_day_max_price',
        'upcoming_inspections_start_time',
        'upcoming_inspections_end_time',
        'available_start_date',
        'available_end_date',
        'sort_number',
        'show',
        'state',
        'owner_id',
        'video_embedded_code',
        'pv',
        'uv'
    ];

    protected $casts = [
        'bathrooms' => 'int',
        'bedrooms' => 'int',
        'car_spaces' => 'int',
        'lockup_garages' => 'int',
        'show' => 'int',
        'sort_number' => 'int',
        'property_type_id' => 'int',
        'per_month_min_price' => 'int',
        'per_month_max_price' => 'int',
        'per_week_min_price' => 'int',
        'per_week_max_price' => 'int',
        'per_day_min_price' => 'int',
        'per_day_max_price' => 'int',
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

    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = json_encode($address);
    }

    public function getAddressAttribute($address)
    {
        return json_decode($address);
    }

    public function owner()
    {
        return $this->belongsTo(PropertyOwner::class, 'owner_id', 'id');
    }

    public function agents()
    {
        return $this->belongsToMany(CompanyMember::class, 'lease_agent', 'lease_id', 'member_id');
    }

    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'creator_id', 'id');
    }

    public function propertyType()
    {
        return $this->belongsToMany(PropertyType::class, 'lease_property_type', 'lease_id', 'property_type_id');
    }

    public function remarks()
    {
        return $this->hasMany(LeaseRemark::class, 'lease_id', 'id');
    }
}
