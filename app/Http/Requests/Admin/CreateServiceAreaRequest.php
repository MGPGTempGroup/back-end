<?php

namespace App\Http\Requests\Admin;

class CreateServiceAreaRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'broadcast_pictures' => 'bail|required|json',
            'introduction' => 'bail|required|string'
        ];
    }
}
