<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdatePropertyOwnerRequest extends BaseRequest
{
    public function rules()
    {
        $ownerId = $this->property_owner->id;
        return [
            'name' => 'bail|string',
            'surname' => 'string',
            'phone' => [
                'bail',
                'nullable',
                'string',
                Rule::unique('property_owners', 'phone')->ignore($ownerId)
            ],
            'email' => [
                'bail',
                'nullable',
                'string',
                Rule::unique('property_owners', 'email')->ignore($ownerId)
            ],
            'wechat' => [
                'bail',
                'nullable',
                'string',
                Rule::unique('property_owners', 'wechat')->ignore($ownerId)
            ],
            'id_card' => [
                'bail',
                'nullable',
                'string',
                Rule::unique('property_owners', 'id_card')->ignore($ownerId)
            ],
            'address' => 'array',
            'identity_id' => 'bail|exists:customer_identities,id'
        ];
    }
}
