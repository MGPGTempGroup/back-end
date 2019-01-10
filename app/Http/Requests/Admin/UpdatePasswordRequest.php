<?php

namespace App\Http\Requests\Admin;

class UpdatePasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'old_pwd' => 'required|string|min:6',
            'new_pwd' => 'bail|required|string|min:6|confirmed'
        ];
    }
}
