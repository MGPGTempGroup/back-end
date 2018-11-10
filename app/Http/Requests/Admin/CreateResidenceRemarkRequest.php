<?php

namespace App\Http\Requests\Admin;

class CreateResidenceRemarkRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'admin_user_id' => 'bail|required|exists:admin_users,id',
            'content' => 'bail|required|string'
        ];
    }
}
