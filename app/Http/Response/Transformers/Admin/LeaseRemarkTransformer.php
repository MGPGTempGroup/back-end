<?php

namespace App\Http\Response\Transformers\Admin;

use App\LeaseRemark;
use League\Fractal\TransformerAbstract;

class LeaseRemarkTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'creator'
    ];

    public function transform(LeaseRemark $leaseRemark)
    {
        return [
            'id' => $leaseRemark->id,
            'admin_user_id' => $leaseRemark->admin_user_id,
            'content' => $leaseRemark->content,
            'lease_id' => $leaseRemark->lease_id,
            'created_at' => $leaseRemark->created_at->toDateTimeString(),
            'updated_at' => $leaseRemark->updated_at->toDateTimeString()
        ];
    }

    public function includeCreator(LeaseRemark $leaseRemark)
    {
        return $this->item($leaseRemark->creator, new AdminUserTransformer());
    }


}
