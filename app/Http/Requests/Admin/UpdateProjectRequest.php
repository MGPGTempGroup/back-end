<?php

namespace App\Http\Requests\Admin;

class UpdateProjectRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'location' => 'string',
            'address' => 'array',
            'status' => 'in:0,1,2,3,4,5,6',
            'introduction' => 'string',
            'description' => 'string',
            'year_built' => 'date',
            'is_new_development' => 'in:0,1',
            'is_past_success' => 'in:0,1',
            'min_price' => 'numeric',
            'max_price' => 'numeric',
            'broadcast_pictures' => 'array',
            'product_type' => 'array',
            'agents' => 'array',
            'owner_id' => 'exists:property_owners,id'
        ];
    }
}
