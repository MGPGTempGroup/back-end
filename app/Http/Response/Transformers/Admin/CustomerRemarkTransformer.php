<?php

namespace App\Http\Response\Transformers\Admin;

use App\CustomerRemark;
use League\Fractal\TransformerAbstract;

class CustomerRemarkTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'creator'
    ];

    public function transform(CustomerRemark $customerRemark)
    {
        return [
            'id' => $customerRemark->id,
            'admin_user_id' => (int) $customerRemark->admin_user_id,
            'customer_id' => (int) $customerRemark->customer_id,
            'content' => $customerRemark->content,
            'created_at' => $customerRemark->created_at->toDateTimeString(),
            'updated_at' => $customerRemark->updated_at->toDateTimeString()
        ];
    }

    public function includeCreator(CustomerRemark $customerRemark)
    {
        return $this->item($customerRemark->creator, new AdminUserTransformer());
    }

}
