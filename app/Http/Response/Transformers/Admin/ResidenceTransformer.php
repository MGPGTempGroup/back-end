<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Residence;

class ResidenceTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'owner', 'creator', 'agents'
    ];

    public function transform(Residence $residence)
    {
        return [
            'id' => $residence->id,
            'name' => $residence->name,
            'property_type' => $residence->propertyType,
            'brief_introduction' => $residence->brief_introduction,
            'floor_space' => $residence->floor_space,
            'details' => $residence->details,
            'broadcast_pictures' => $residence->broadcast_pictures,
            'address' => $residence->address,
            'suburb_name' => $residence->suburb_name,
            'street_name' => $residence->street_name,
            'street_code' => $residence->street_code,
            'house_number' => $residence->house_number,
            'post_code' => $residence->post_code,
            'address_description' => $residence->address_description,
            'map_coordinates' => $residence->map_coordinates,
            'bedrooms' => $residence->bedrooms,
            'bathrooms' => $residence->bathrooms,
            'car_spaces' => $residence->car_ports,
            'lockup_garages' => $residence->lockup_garages,
            'min_price' => $residence->min_price,
            'max_price' => $residence->max_price,
            'upcoming_inspection_datetime' => $residence->upcoming_inspection_datetime,
            'available_start_date' => $residence->available_start_date,
            'available_end_date' => $residence->available_end_date,
            'constructed_in' => $residence->constructed_in,
            'built_in' => $residence->built_in,
            'sort_number' => $residence->sort_number,
            'show' => $residence->show,
            'is_new_development' => $residence->is_new_development,
            'state' => $residence->state,
            'owner_id' => $residence->owner_id,
            'video_embedded_code' => $residence->video_embedded_code,
            'pv' => $residence->pv,
            'uv' => $residence->uv,
            'created_at' => $residence->created_at->toDateTimeString(),
            'updated_at' => $residence->updated_at->toDateTimeString(),
            'information_statement' => $residence->information_statement
        ];
    }

    public function includeOwner(Residence $residence)
    {
        if (! $owner = $residence->owner) return $this->null();
        return $this->item($owner, new PropertyOwnerTransformer());
    }

    public function includeCreator(Residence $residence)
    {
        return $this->item($residence->creator, new AdminUserTransformer());
    }

    public function includeAgents(Residence $residence)
    {
        return $this->collection($residence->agents, new CompanyMemberTransformer());
    }


}
