<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateResidenceRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'property_type' => 'required|exists:property_types,id',
            'introduction' => 'required|string',
            'floor_space' => 'required|number',
            'details' => 'required|string',
            'broadcast_pictures' => 'required|json',
            'country_code' => 'required|string',
            'state_code' => 'required|string',
            'city_code' => 'required|string',
            'part_name' => 'required|string',
            'street_name' => 'required|string',
            'street_code' => 'required|string',
            'house_number' => 'required|string',
            'post_code' => 'required|string',
            'detailed_address' => 'string',
            'address_description' => 'string',
            'map_coordinates' => 'string',
            'bedrooms' => 'number',
            'bathrooms' => 'number',
            'car_ports' => 'number',
            'lockup_garages' => 'number',
            'min_price' => 'required|number',
            'max_price' => 'required|number',
            'upcoming_inspections_start_time' => 'date',
            'upcoming_inspections_end_time' => 'date',
            'available_date' => 'string|date',
            'constructed_in' => 'date',
            'built_in' => 'date',
            'sort_number' => 'number',
            'is_new_development' => 'in:0,1',
            'state' => 'in:0,1,2,3',
//            'owner_id' => 'exists:customer_'
        ];
    }
}
