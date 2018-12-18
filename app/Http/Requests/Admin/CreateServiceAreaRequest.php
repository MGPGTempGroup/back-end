<?php

namespace App\Http\Requests\Admin;

class CreateServiceAreaRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'top_picture' => 'url',
            'picture' => 'url',
            'introduction' => 'bail|required|string'
        ];
    }
}
