<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\CompanyDepartment;

class CompanyDepartmentTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'positions'
    ];

    public function transform(CompanyDepartment $companyDepartment)
    {
        return [
            'id' => $companyDepartment->id,
            'name' => $companyDepartment->name,
            'created_at' => $companyDepartment->created_at->toDateTimeString(),
            'updated_at' => $companyDepartment->updated_at->toDateTimeString()
        ];
    }

    public function includePositions(CompanyDepartment $companyDepartment)
    {
        return $this->collection($companyDepartment->positions, new CompanyMemberPositionTransformer());
    }

}
