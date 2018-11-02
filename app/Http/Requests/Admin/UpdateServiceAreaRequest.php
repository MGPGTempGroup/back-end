<?php

namespace App\Http\Requests\Admin;

class UpdateServiceAreaRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|string',
            'broadcast_pictures' => 'bail|json',
            'introduction' => 'bail|string'
        ];
    }
}
