<?php

namespace App\Http\Response\Transformers\Home;

use App\CompanyMember;
use League\Fractal\TransformerAbstract;

class CompanyMemberTransformer extends TransformerAbstract
{
    public function transform(CompanyMember $companyMember)
    {
        return [
            'id' => $companyMember->id,
            'surname' => $companyMember->surname,
            'name' => $companyMember->name,
            'phone' => $companyMember->phone,
            'email' => $companyMember->email,
            'photo' => $companyMember->photo,
        ];
    }
}
