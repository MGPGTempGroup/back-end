<?php

namespace App\Http\Requests\Admin;

use App\CompanyMember;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => [
                'string',
                Rule::unique('customers', 'name')->ignore($this->customer)
            ],
            'surname' =>'string',
            'identity_id' => 'exists:customer_identities,id',
            'members_id' => [
                'array',
                function ($k, $v, $fail) {
                    // 取出所有公司成员的id （数据量较少选择直接取出）
                    $existedMemberIdList = CompanyMember::select('id')->pluck('id')->toArray();

                    // 验证提交的id是否全部存在：取提交id列表与现有成员id列表的交集
                    if(array_intersect($v, $existedMemberIdList) !== $v) {
                        return $fail('The submitted member ID is not all exist.');
                    }
                }
            ],
            'phone' => [
                'string',
                Rule::unique('customers', 'phone')->ignore($this->customer)
            ],
            'email' => [
                'string',
                'email',
                Rule::unique('customers', 'email')->ignore($this->customer)
            ],
            'wechat' => [
                'string',
                Rule::unique('customers', 'wechat')->ignore($this->customer)
            ],
            'address' => 'string'
        ];
    }
}
