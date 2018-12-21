<?php

namespace App\Http\Requests\Admin;

class UpdateIndustryUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title' => 'string|max:191',
            'content' => 'string',
            'first_picture' => 'url',
            'top_picture' => 'url'
        ];
    }
}
