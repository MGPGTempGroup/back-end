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

        // 判断是否包含positions参数，如果包含则查询出对应职位的公司成员
        if (is_array($positions = $request->query('positions')) && $positions) {
            $members_id = $memberPositionPivot->select('member_id')
                ->whereIn('position_id', $positions)
                ->pluck('member_id')
                ->toArray();
            $eloquentBuilder = $eloquentBuilder->whereIn('id', $members_id);
        }

        // 判断是否包含searchByFullName参数，如果包含则根据添加FullName模糊查询条件
        if ($fullName = $request->query('searchByFullName')) {
            $members = $eloquentBuilder
                ->whereRaw('concat(surname, " ", name) like ?', ['%' . $fullName . '%'])
                ->get();
            return $this->response->collection($members, new CompanyMemberTransformer());
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

        $syncResult = $companyMember->positions()->sync($request->positions);
        DB::table('company_member_positions')
            ->whereIn('id', $syncResult['attached'])
            ->increment('members_count');
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
            $syncResult = $companyMember->positions()->sync($request->positions);
            $countField = 'members_count';
            DB::table('company_member_positions')
                ->whereIn('id', $syncResult['attached'])
                ->increment($countField);
            DB::table('company_member_positions')
                ->whereIn('id', $syncResult['detached'])
                ->decrement($countField);
        }
        return $this->response->item($companyMember, new CompanyMemberTransformer());
    }

    /**
     * 删除公司成员
     */
    public function destroy(CompanyMember $companyMember)
    {
        $syncResult = $companyMember->positions()->sync([]);
        DB::table('company_member_positions')
            ->whereIn('id', $syncResult['detached'])
            ->decrement('members_count');
        return $this->response->noContent();
    }
}
