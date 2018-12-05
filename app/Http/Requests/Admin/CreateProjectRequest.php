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
            'broadcast_pictures' => 'array',
            'product_type' => 'array',
            'agents' => 'array'
        ];
    }
}
