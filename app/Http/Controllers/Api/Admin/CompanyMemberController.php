<?php

namespace App\Http\Controllers\Api\Admin;

use App\CompanyMemberPosition;
use App\Http\Controllers\Controller;

use App\CompanyMember;
use App\Http\Requests\Admin\UpdateCompanyMemberRequest;
use App\Http\Requests\Admin\CreateCompanyMemberRequest;
use App\Http\Response\Transformers\Admin\CompanyMemberTransformer;
use App\MemberPositionPivot;
use Illuminate\Http\Request;

use DB;

class CompanyMemberController extends Controller
{

    /**
     * 获取公司成员列表接口
     */
    public function index(Request $request, CompanyMember $companyMember, MemberPositionPivot $memberPositionPivot)
    {

        $eloquentBuilder = $this->buildEloquentQueryThroughQs($companyMember);

        if (is_array($positions = $request->query('positions')) && $positions) {
            // 查询出对应职位的所有成员id
            $members_id = $memberPositionPivot->select('member_id')
                ->whereIn('position_id', $positions)
                ->pluck('member_id')
                ->toArray();
            $eloquentBuilder = $eloquentBuilder->whereIn('id', $members_id);
        }

        $members = $eloquentBuilder->paginate();

        return $this->response->paginator($members, new CompanyMemberTransformer());
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
