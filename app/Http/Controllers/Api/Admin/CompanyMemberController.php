<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

use App\CompanyMember;
use App\Http\Requests\Admin\UpdateCompanyMemberRequest;
use App\Http\Requests\Admin\CreateCompanyMemberRequest;
use App\Http\Response\Transformers\Admin\CompanyMemberTransformer;

class CompanyMemberController extends Controller
{

    /**
     * 获取公司成员列表接口
     */
    public function index(CompanyMember $companyMember)
    {
        return $this->response->collection($companyMember->get(), new CompanyMemberTransformer());
    }

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
    public function store(CreateCompanyMemberRequest $request, CompanyMember $companyMember)
    {
        $companyMember->fill($request->all());
        $companyMember->save();
        $companyMember->positions()->attach($request->positions);
        return $this->response->item($companyMember, new CompanyMemberTransformer());
    }

    /**
     * 修改公司成员接口
     */
    public function update(UpdateCompanyMemberRequest $request, CompanyMember $companyMember)
    {
        $companyMember->fill($request->all());
        $companyMember->save();
        if ($request->positions) {
            $companyMember->positions()->sync($request->positions);
        }
        return $this->response->item($companyMember, new CompanyMemberTransformer());
    }

    /**
     * 删除公司成员
     */
    public function destroy(CompanyMember $companyMember)
    {
        $companyMember->delete();
        return $this->response->noContent();
    }
}
