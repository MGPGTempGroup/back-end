<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Response\Transformers\Admin\CompanyDepartmentTransformer;
use App\Http\Response\Transformers\Admin\CompanyMemberPositionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CompanyMemberPosition;
use App\CompanyDepartment;

class CompanyMemberPositionController extends Controller
{
    /**
     * 获取公司职位列表
     */
    public function index(CompanyMemberPosition $companyMemberPosition)
    {
        return $this->response->collection(
            $companyMemberPosition->get(),
            new CompanyMemberPositionTransformer());
    }

    /**
     * 获取公司部门列表
     */
    public function showDepartments(CompanyDepartment $companyDepartment)
    {
        return $this->response->collection(
            $companyDepartment->get(),
            new CompanyDepartmentTransformer());
    }
}
