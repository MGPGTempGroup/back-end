<?php

namespace App\Http\Requests\Home;

class CreateHouseInspectionRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required|string',
            'email' => 'string',
            'comment' => 'required|string',
            'surname' => 'required|string',
            'first_name' => 'string',
            'preferred_inspection_datetime' => 'bail|required|date', // debug: timezone after_or_equal:today
            'preferred_move_in_date' => 'date',
            'mobile_from_country' => 'string',
        ];
    }
}
