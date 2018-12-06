<?php

namespace App\Http\Requests\Admin;

class CreateProjectRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'location' => 'bail|required|string',
            'address' => 'bail|required|array',
            'status' => 'bail|required|in:0,1,2,3,4,5,6',
            'introduction' => 'string',
            'description' => 'string',
            'year_built' => 'date',
            'is_new_development' => 'in:0,1',
            'is_past_success' => 'in:0,1',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'broadcast_pictures' => 'array',
            'product_type' => 'array',
            'agents' => 'array',
            'owner_id' => 'exists:property_owners,id'
        ];
    }
}
