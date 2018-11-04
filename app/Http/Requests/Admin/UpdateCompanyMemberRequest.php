<?php

namespace App\Http\Requests\Admin;

use App\CompanyMemberPosition;

class UpdateCompanyMemberRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'google_plus_homepage' => 'url',
            'linkin_homepage' => 'url',
            'introduction' => 'string',
            'photo' => 'string', // image key
            'thumbnail' => 'string', // image key
            'positions' => [
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
