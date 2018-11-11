<?php

namespace App\Http\Requests\Admin;

use App\CompanyMember;

class CreateCustomerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'string|unique:customers,name',
            'surname' =>'bail|required|string',
            'identity_id' => 'bail|required|exists:customer_identities,id',
            'members_id' => [
                'array',
                function ($k, $v, $fail) {
                    // 取出所有公司成员的id （数据量较少选择直接取出）
                    $existedMemberIdList = CompanyMember::select('id')->pluck('id')->toArray();

                    // 验证提交的id是否全部存在：取提交id列表与现有成员id列表的交集
                    if (array_intersect($v, $existedMemberIdList) !== $v) {
                        return $fail('The submitted member ID is not all exist.');
                    }
                }
            ],
            'phone' => 'bail|string|required_without_all:email,wechat|unique:customers,phone',
            'email' => 'bail|string|email|required_without_all:phone,wechat|unique:customers,email',
            'wechat' => 'bail|string|required_without_all:phone,email|unique:customers,wechat',
            'address' => 'string'
        ];
    }
}
