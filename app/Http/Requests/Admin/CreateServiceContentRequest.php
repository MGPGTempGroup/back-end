<?php

namespace App\Http\Requests\Admin;

class CreateServiceContentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'broadcast_pictures' => 'array',
            'content' => 'required|string'
        ];
    }
}
