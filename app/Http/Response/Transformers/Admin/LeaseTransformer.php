<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Lease;

class LeaseTransformer extends TransformerAbstract
{
    public function transform(Lease $lease)
    {
        return [
            'id' => $lease->id,
            'name' => $lease->name,
            'property_type' => $lease->propertyType,
            'introduction' => $lease->introduction,
            'floor_space' => $lease->floor_space,
            'details' => $lease->details,
            'broadcast_pictures' => $lease->broadcast_pictures,
            'area_name' => $lease->area_name,
            'suburb_name' => $lease->suburb_name,
            'street_name' => $lease->street_name,
            'street_code' => $lease->street_code,
            'house_number' => $lease->house_number,
            'post_code' => $lease->post_code,
            'address' => $lease->address,
            'detailed_address' => $lease->detailed_address,
            'address_description' => $lease->address_description,
            'map_coordinates' => $lease->map_coordinates,
            'bedrooms' => $lease->bedrooms,
            'bathrooms' => $lease->bathrooms,
            'car_ports' => $lease->car_ports,
            'lockup_garages' => $lease->lockup_garages,
            'per_month_min_price' => $lease->per_month_min_price,
            'per_month_max_price' => $lease->per_month_max_price,
            'per_week_min_price' => $lease->per_week_min_price,
            'per_week_max_price' => $lease->per_week_max_price,
            'per_day_min_price' => $lease->per_day_min_price,
            'per_day_max_price' => $lease->per_day_max_price,
            'upcoming_inspections_start_time' => $lease->upcoming_inspections_start_time,
            'upcoming_inspections_end_time' => $lease->upcoming_inspection_end_time,
            'available_start_date' => $lease->available_start_date,
            'available_end_date' => $lease->available_end_date,
            'sort_number' => $lease->sort_number,
            'show' => $lease->show,
            'state' => $lease->state,
            'owner_id' => $lease->owner_id,
            'owner' => $lease->owner,
            'pv' => $lease->pv,
            'uv' => $lease->uv,
            'created_at' => $lease->created_at->toDateTimeString(),
            'updated_at' => $lease->updated_at->toDateTimeString()
        ];
    }
}
