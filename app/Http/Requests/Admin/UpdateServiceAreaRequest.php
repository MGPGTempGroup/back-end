<?php

namespace App\Http\Requests\Admin;

class UpdateServiceAreaRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'top_picture' => 'url',
            'picture' => 'url',
            'introduction' => 'string'
        ];
    }
}
