<?php

namespace App\Http\Requests\Admin;

class CreateIndustryUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'title' => 'bail|required|string|max:191',
            'content' => 'bail|required|string',
            'first_picture' => 'nullable|url',
            'top_picture' => 'nullable|url'
        ];
    }
}
