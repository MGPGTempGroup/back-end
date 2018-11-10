<?php

namespace App\Http\Response\Transformers\Admin;

use App\LeaseRemark;
use League\Fractal\TransformerAbstract;

class LeaseRemarkTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'admin_user'
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

    public function includeAdminUser(LeaseRemark $leaseRemark)
    {
        return $this->item($leaseRemark->adminUser, new AdminUserTransformer());
    }


}
