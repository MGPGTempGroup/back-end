<?php

namespace App\Http\Response\Transformers\Admin;

use App\CustomerIdentity;
use League\Fractal\TransformerAbstract;

class CustomerIdentityTransformer extends TransformerAbstract
{
    public function transform(CustomerIdentity $customerIdentity)
    {
        return [
            'id' => $customerIdentity->id,
            'name' => $customerIdentity->name,
            'created_at' => $customerIdentity->created_at->toDateTimeString(),
            'updated_at' => $customerIdentity->updated_at->toDateTimeString()
        ];
    }
}
