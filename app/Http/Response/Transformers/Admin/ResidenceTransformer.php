<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Residence;

class ResidenceTransformer extends TransformerAbstract
{
    public function transform(Residence $residence)
    {
        return [
            'id' => $residence->id,
            'name' => $residence->name,
            'property_type' => $residence->propertyType,
            'introduction' => $residence->introduction,
            'floor_space' => $residence->floor_space,
            'details' => $residence->details,
            'broadcast_pictures' => $residence->broadcast_pictures,
            'country_code' => $residence->country_code,
            'state_code' => $residence->state_code,
            'city_code' => $residence->city_code,
            'area_name' => $residence->area_name,
            'suburb_name' => $residence->suburb_name,
            'street_name' => $residence->street_name,
            'street_code' => $residence->street_code,
            'house_number' => $residence->house_number,
            'post_code' => $residence->post_code,
            'detailed_address' => $residence->detailed_address,
            'address_description' => $residence->address_description,
            'map_coordinates' => $residence->map_coordinates,
            'bedrooms' => $residence->bedrooms,
            'bathrooms' => $residence->bathrooms,
            'car_ports' => $residence->car_ports,
            'lockup_garages' => $residence->lockup_garages,
            'min_price' => $residence->min_price,
            'max_price' => $residence->max_price,
            'upcoming_inspections_start_time' => $residence->upcoming_inspections_start_time,
            'upcoming_inspections_end_time' => $residence->upcoming_inspection_end_time,
            'available_start_date' => $residence->available_start_date,
            'available_end_date' => $residence->available_end_date,
            'constructed_in' => $residence->constructed_in,
            'built_in' => $residence->built_in,
            'sort_number' => $residence->sort_number,
            'show' => $residence->show,
            'is_new_development' => $residence->is_new_development,
            'state' => $residence->state,
            'owner_id' => $residence->owner_id,
            'owner' => $residence->owner,
            'pv' => $residence->pv,
            'uv' => $residence->uv,
            'created_at' => $residence->created_at->toDateTimeString(),
            'updated_at' => $residence->updated_at->toDateTimeString()
        ];
    }
}
