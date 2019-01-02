<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\PropertyOwner;

class PropertyOwnerTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['remarks'];

    protected $defaultIncludes = ['identity'];

    public function transform(PropertyOwner $propertyOwner)
    {
        return [
            'id' => $propertyOwner->id,
            'surname' => $propertyOwner->surname,
            'name' => $propertyOwner->name,
            'email' => $propertyOwner->email,
            'phone' => $propertyOwner->phone,
            'wechat' => $propertyOwner->wechat,
            'id_card' => $propertyOwner->id_card,
            'identity_id' => (int) $propertyOwner->identity_id,
            'address' => $propertyOwner->address,
            'created_at' => $propertyOwner->created_at->toDateTimeString(),
            'updated_at' => $propertyOwner->updated_at->toDateTimeString()
        ];
    }

    public function includeIdentity(PropertyOwner $propertyOwner)
    {
        return $this->item($propertyOwner->identity, new CustomerIdentityTransformer());
    }

    public function includeRemarks(PropertyOwner $propertyOwner)
    {
        $remarks = $propertyOwner->remarks;
        if ($remarks) {
            return $this->collection($remarksm, new RemarkTransformer());
        }
        return $this->null();
    }

}
