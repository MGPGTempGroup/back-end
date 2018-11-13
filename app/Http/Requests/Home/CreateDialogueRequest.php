<?php

namespace App\Http\Requests\Home;

class CreateDialogueRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'email' => 'bail|required|email'
        ];
    }
}
