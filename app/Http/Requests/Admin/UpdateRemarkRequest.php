<?php

namespace App\Http\Requests\Admin;

class UpdateRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'string'
        ];
    }
}
