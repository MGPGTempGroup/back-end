<?php

namespace App\Http\Requests\Admin;

use App\CompanyMember;

class UpdateServiceRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'bail|string',
            'broadcast_pictures' => 'bail|json', // todo: 验证json数据格式
            'members' => [
                'array',
                function ($k, $v, $fail) {
                    $existedMemberIdList = CompanyMember::select('id')->pluck('id')->toArray();
                    if (array_intersect($v, $existedMemberIdList) !== $v) {
                        return $fail('Member ID is not all exist.');
                    }
                }
            ]
        ];
    }
}
