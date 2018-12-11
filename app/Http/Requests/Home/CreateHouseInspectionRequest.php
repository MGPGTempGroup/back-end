<?php

namespace App\Http\Requests\Home;

class CreateHouseInspectionRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required|string',
            'comment' => 'required|string',
            'surname' => 'required|string',
            'first_name' => 'string',
            'inspection_date' => 'bail|required|date|after:today',
            'inspection_time' => 'date_format:H:i:s'
        ];
    }
}
