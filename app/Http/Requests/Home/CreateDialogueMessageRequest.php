<?php

namespace App\Http\Requests\Home;

class CreateDialogueMessageRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'bail|required|string'
        ];
    }
}
