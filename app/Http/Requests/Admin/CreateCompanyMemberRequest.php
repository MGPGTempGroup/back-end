<?php

namespace App\Http\Requests\Admin;
use Illuminate\Validation\Rule;
use App\CompanyMemberPosition;

class CreateCompanyMemberRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|string',
            'google_plus_homepage' => 'url',
            'linkin_homepage' => 'url',
            'introduction' => 'string',
            'photo' => 'string', // image key
            'thumbnail' => 'string', // image key
            'positions' => [
                'required',
                'string',
                function($field, $val, $fail) {
                    $existedID = CompanyMemberPosition::select('id')->pluck('id')->toArray();
                    $positionsID = explode(',', $val);
                    if (array_intersect($positionsID, $existedID) !== $positionsID)
                        $fail('Member Positions contains ID that does not exist.');
                }
            ]
        ];
    }
}
