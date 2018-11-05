<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\PropertyOwner;

class PropertyOwnerTransformer extends TransformerAbstract
{
    public function transform(PropertyOwner $propertyOwner)
    {
        return [
            'id' => $propertyOwner->id,
            'name' => $propertyOwner->name,
            'email' => $propertyOwner->email,
            'phone' => $propertyOwner->phone,
            'address' => $propertyOwner->address,
            'created_at' => $propertyOwner->created_at->toDateTimeString(),
            'updated_at' => $propertyOwner->updated_at->toDateTimeString()
        ];
    }
}
