<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\CompanyMemberPosition;

class CompanyMemberPositionTransformer extends TransformerAbstract
{
    public function transform(CompanyMemberPosition $companyMemberPosition)
    {
        return [
            'id' => $companyMemberPosition->id,
            'name' => $companyMemberPosition->name,
            'department' => $companyMemberPosition->department,
            'created_at' => $companyMemberPosition->created_at->toDateTimeString(),
            'updated_at' => $companyMemberPosition->updated_at->toDateTimeString()
        ];
    }
}
