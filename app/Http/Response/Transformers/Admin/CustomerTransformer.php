<?php

namespace App\Http\Response\Transformers\Admin;

use App\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'identity', 'members'
    ];

    public function transform(Customer $customer)
    {
        return [
            'id' => (int) $customer->id,
            'name' => $customer->name,
            'surname' => $customer->surname,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'wechat' => $customer->wechat,
            'address' => $customer->address,
            'identity_id' => (int) $customer->identity_id,
            'created_at' => $customer->created_at->toDateTimeString(),
            'updated_at' => $customer->updated_at->toDateTimeString()
        ];
    }

    public function includeIdentity(Customer $customer)
    {
        return $this->item($customer->identity, new CustomerIdentityTransformer());
    }

    public function includeMembers(Customer $customer)
    {
        return $this->collection($customer->members, new CompanyMemberTransformer());
    }

}
