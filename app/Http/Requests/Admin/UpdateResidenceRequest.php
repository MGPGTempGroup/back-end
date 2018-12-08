<?php

namespace App\Http\Requests\Admin;

use App\PropertyType;

class UpdateResidenceRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'property_type_id' => [
                'array',
                function ($k, $v, $fail) {
                    $idList = array_map(function ($item) {
                        return (int) $item;
                    }, $v);
                    if (PropertyType::whereIn('id', $idList)->count() !== count($idList)) {
                        return $fail('Property type ID does not exist.');
                    }
                    $this->merge([
                        'property_type_id' => $idList
                    ]);
                }
            ],
            'introduction' => 'string',
            'floor_space' => 'numeric',
            'details' => 'string',
            'broadcast_pictures' => 'array',
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
            'min_price' => 'numeric',
            'max_price' => 'numeric',
            'upcoming_inspections_start_time' => 'date',
            'upcoming_inspections_end_time' => 'date',
            'available_start_date' => 'date',
            'available_end_date' => 'date',
            'constructed_in' => 'date',
            'built_in' => 'date',
            'sort_number' => 'numeric',
            'is_new_development' => 'in:0,1',
            'state' => 'in:0,1,2',
            'owner_id' => 'exists:property_owners,id',
            'information_statement' => 'url'
        ];
    }
}
