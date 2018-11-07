<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lease extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'property_type_id',
        'introduction',
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
        'detailed_address',
        'address_description',
        'map_coordinates',
        'bathrooms',
        'bedrooms',
        'car_ports',
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
        'pv',
        'uv'
    ];

    protected $casts = [
        'bathrooms' => 'int',
        'bedrooms' => 'int',
        'car_ports' => 'int',
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
        'car_ports' => 0,
        'lockup_garages' => 0,
        'pv' => 0,
        'uv' => 0,
        'show' => 1,
        'sort_number' => 0,
    ];

    public function owner()
    {
        return $this->belongsTo(PropertyOwner::class, 'owner_id', 'id');
    }

    public function property_type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id', 'id');
    }
}
