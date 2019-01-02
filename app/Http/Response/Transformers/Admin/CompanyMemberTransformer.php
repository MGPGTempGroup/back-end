<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\CompanyMember;

class CompanyMemberTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['remarks'];

    protected $defaultIncludes = ['positions'];

    public function transform(CompanyMember $companyMember)
    {
        return [
            'id' => $companyMember->id,
            'surname' => $companyMember->surname,
            'name' => $companyMember->name,
            'phone' => $companyMember->phone,
            'email' => $companyMember->email,
            'google_plus_homepage' => $companyMember->google_plus_homepage,
            'linkin_homepage' => $companyMember->linkin_homepage,
            'introduction' => $companyMember->introduction,
            'photo' => $companyMember->photo,
            'thumbnail' => $companyMember->thumbnail,
            'created_at' => $companyMember->created_at->toDateTimeString(),
            'updated_at' => $companyMember->updated_at->toDateTimeString()
        ];
    }

    public function includePositions(CompanyMember $companyMember)
    {
        return $this->collection($companyMember->positions, new CompanyMemberPositionTransformer());
    }

    public function includeRemarks(CompanyMember $companyMember)
    {
        $remarks = $companyMember->remarks;
        if ($remarks) {
            return $this->collection($remarks, new RemarkTransformer());
        }
        return $this->null();
    }

}
