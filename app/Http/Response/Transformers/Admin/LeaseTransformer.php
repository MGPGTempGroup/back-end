<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Lease;

class LeaseTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'owner', 'agents', 'creator'
    ];

    public function transform(Lease $lease)
    {
        return [
            'id' => $lease->id,
            'name' => $lease->name,
            'property_type' => $lease->propertyType,
            'brief_introduction' => $lease->brief_introduction,
            'floor_space' => $lease->floor_space,
            'details' => $lease->details,
            'broadcast_pictures' => $lease->broadcast_pictures,
            'address' => $lease->address,
            'suburb_name' => $lease->suburb_name,
            'street_name' => $lease->street_name,
            'street_code' => $lease->street_code,
            'house_number' => $lease->house_number,
            'post_code' => $lease->post_code,
            'address_description' => $lease->address_description,
            'map_coordinates' => $lease->map_coordinates,
            'bedrooms' => $lease->bedrooms,
            'bathrooms' => $lease->bathrooms,
            'car_spaces' => $lease->car_spaces,
            'lockup_garages' => $lease->lockup_garages,
            'per_month_min_price' => $lease->per_month_min_price,
            'per_month_max_price' => $lease->per_month_max_price,
            'per_week_min_price' => $lease->per_week_min_price,
            'per_week_max_price' => $lease->per_week_max_price,
            'per_day_min_price' => $lease->per_day_min_price,
            'per_day_max_price' => $lease->per_day_max_price,
            'upcoming_inspection_datetime' => $lease->upcoming_inspection_datetime,
            'available_start_date' => $lease->available_start_date,
            'available_end_date' => $lease->available_end_date,
            'sort_number' => $lease->sort_number,
            'show' => $lease->show,
            'state' => $lease->state,
            'owner_id' => $lease->owner_id,
            'video_embedded_code' => $lease->video_embedded_code,
            'pv' => $lease->pv,
            'uv' => $lease->uv,
            'created_at' => $lease->created_at->toDateTimeString(),
            'updated_at' => $lease->updated_at->toDateTimeString()
        ];
    }

    public function includeOwner(Lease $lease)
    {
        return $this->item($lease->owner, new PropertyOwnerTransformer());
    }

    public function includeAgents(Lease $lease)
    {
        return $this->collection($lease->agents, new CompanyMemberTransformer());
    }

    public function includeCreator(Lease $lease)
    {
        return $this->item($lease->creator, new AdminUserTransformer());
    }

}
