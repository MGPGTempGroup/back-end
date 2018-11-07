<?php

namespace App\Http\Requests\Admin;

class UpdateLeaseRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'property_type_id' => 'exists:property_types,id',
            'introduction' => 'string',
            'floor_space' => 'numeric',
            'details' => 'string',
            'broadcast_pictures' => 'json',
            'country_code' => 'string',
            'state_code' => 'string',
            'city_code' => 'string',
            'area_name' => 'string',
            'suburb_name' => 'string',
            'street_name' => 'string',
            'street_code' => 'string',
            'house_number' => 'string',
            'post_code' => 'string',
            'detailed_address' => 'string',
            'address_description' => 'string',
            'map_coordinates' => 'string',
            'bedrooms' => 'numeric',
            'bathrooms' => 'numeric',
            'car_ports' => 'numeric',
            'lockup_garages' => 'numeric',
            'per_month_min_price' => 'numeric',
            'per_month_max_price' => 'numeric',
            'per_week_min_price' => 'numeric',
            'per_week_max_price' => 'numeric',
            'per_day_min_price' => 'numeric',
            'per_day_max_price' => 'numeric',
            'upcoming_inspections_start_time' => 'date',
            'upcoming_inspections_end_time' => 'date',
            'available_start_date' => 'date',
            'available_end_date' => 'date',
            'sort_number' => 'numeric',
            'state' => 'in:0,1,2',
            'owner_id' => 'exists:property_owners,id',
        ];
    }
}
