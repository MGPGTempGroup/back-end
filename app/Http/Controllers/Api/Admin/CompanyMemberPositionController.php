<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateCompanyDepartmentRequest;
use App\Http\Requests\Admin\CreateCompanyMemberPositionRequest;
use App\Http\Requests\Admin\UpdateCompanyDepartmentRequest;
use App\Http\Requests\Admin\UpdateCompanyMemberPositionRequest;
use App\Http\Response\Transformers\Admin\CompanyDepartmentTransformer;
use App\Http\Response\Transformers\Admin\CompanyMemberPositionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CompanyMemberPosition;
use App\CompanyDepartment;

use DB;

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

//    /**
//     * 创建公司职位
//     */
//    public function store(CreateCompanyMemberPositionRequest $request, CompanyMemberPosition $companyMemberPosition)
//    {
//        $companyMemberPosition->fill($request->all());
//        $companyMemberPosition->save();
//        return $this->response->item($companyMemberPosition, new CompanyMemberPositionTransformer());
//    }

    /**
     * 批量创建公司职位
     */
    public function batchStore(
        CreateCompanyMemberPositionRequest $request,
        CompanyDepartment $companyDepartment
    )
    {
        $positionNames = collect($request->input('positions'));
        $positions = $positionNames->map(function ($name) use ($companyDepartment) {
            $companyMemberPosition = new CompanyMemberPosition();
            $companyMemberPosition->fill([
                'name' => $name,
                'department_id' => $companyDepartment->id
            ]);
            // 这里迭代每一次的save走了队列，没有问题
            $companyMemberPosition->save();
            return $companyMemberPosition;
        });
        return $this->response->collection($positions, new CompanyMemberPositionTransformer());
    }

    /**
     * 修改公司职位
     */
    public function update(UpdateCompanyMemberPositionRequest $request, CompanyMemberPosition $companyMemberPosition)
    {
        $companyMemberPosition->fill($request->all());
        $companyMemberPosition->save();
        return $this->response->item($companyMemberPosition, new CompanyMemberPositionTransformer());
    }

    /**
     * 删除公司职位
     */
    public function destroy(CompanyMemberPosition $companyMemberPosition)
    {
        $syncResult = $companyMemberPosition->members()->sync([]);
        $companyMemberPosition->decrement('members_count', count($syncResult['detached']));
        $companyMemberPosition->delete();
        return $this->response->noContent();
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

    /**
     * 创建公司部门
     */
    public function createDepartment(CreateCompanyDepartmentRequest $request, CompanyDepartment $companyDepartment)
    {
        $companyDepartment->fill($request->all());
        $companyDepartment->save();
        return $this->response->item($companyDepartment, new CompanyDepartmentTransformer());
    }

    /**
     * 修改公司部门
     */
    public function updateDepartment(UpdateCompanyDepartmentRequest $request, CompanyDepartment $companyDepartment)
    {
        $companyDepartment->fill($request->all());
        $companyDepartment->save();
        return $this->response->item($companyDepartment, new CompanyDepartmentTransformer());
    }

    /**
     * 删除公司部门
     */
    public function destroyDepartment(CompanyDepartment $companyDepartment)
    {
        DB::transaction(function () use ($companyDepartment) {
            // 查找出关联职位
            $companyDepartment->positions->each(function ($position) {
                $position->members()->sync([]);
                $position->delete();
            });
            $companyDepartment->delete();
        });
        return $this->response->noContent();
    }
}
