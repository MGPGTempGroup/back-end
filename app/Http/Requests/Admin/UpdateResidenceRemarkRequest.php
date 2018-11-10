<?php

namespace App\Http\Requests\Admin;

class UpdateResidenceRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'bail|required|string'
        ];
    }
}
