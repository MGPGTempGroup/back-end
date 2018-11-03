<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCompanyMemberRequest;

use App\CompanyMember;
use App\Http\Response\Transformers\Admin\CompanyMemberTransformer;

class CompanyMemberController extends Controller
{
    /**
     * 展示单个公司成员详情
     */
    public function show(CompanyMember $companyMember)
    {
        return $this->response->item($companyMember, new CompanyMemberTransformer());
    }

    /**
     * 创建公司成员
     */
    public function create(CreateCompanyMemberRequest $request, CompanyMember $companyMember)
    {
        $companyMember->fill($request->all());
        $companyMember->save();
        $companyMember->positions()->attach(explode(',', $request->positions));
        return $this->response->item($companyMember, new CompanyMemberTransformer());
    }
}
