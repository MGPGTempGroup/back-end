<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateLeaseRequest;
use App\Http\Requests\Admin\UpdateLeaseRequest;
use App\Http\Response\Transformers\Admin\LeaseTransformer;
use App\LeaseAgentPivot;
use App\LeasePropertyTypePivot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lease;

class LeaseController extends Controller
{

    /**
     * 展示租赁房屋列表
     */
    public function index(
        Request $request,
        Lease $lease,
        LeaseAgentPivot $leaseAgentPivot,
        LeasePropertyTypePivot $leasePropertyTypePivot)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($lease);

        // 判断是否包含公司成员（销售代理）id 条件查询参数
        if (is_array(($membersId = $request->query('members'))) && count($membersId)) {
            $leasesId = $leaseAgentPivot
                ->select('lease_id')
                ->whereIn('member_id', $membersId)
                ->pluck('lease_id')
                ->toArray();
            $eloquentBuilder = $eloquentBuilder->whereIn('id', $leasesId);
        }

        // 判断是否包含物业类型 id 条件查询参数
        if (is_array($propertyTypesId = $request->query('property_type')) && count($propertyTypesId) ) {
            $leasesId = $leasePropertyTypePivot
                ->select('lease_id')
                ->whereIn('property_type_id', $propertyTypesId)
                ->pluck('lease_id')
                ->toArray();
            $eloquentBuilder = $eloquentBuilder->whereIn('id', $leasesId);
        }

        $leases = $eloquentBuilder->paginate();
        return $this->response->paginator($leases, new LeaseTransformer());
    }

    /**
     * 展示租赁房屋数据详情
     */
    public function show(Lease $lease)
    {
        return $this->response->item($lease, new LeaseTransformer());
    }

    /**
     * 创建租赁房屋
     */
    public function store(CreateLeaseRequest $request, Lease $lease)
    {
        $lease->fill($request->all());
        $lease->creator_id = $this->user()->id;
        $lease->save();
        $lease->propertyType()->attach($request->input('property_type'));
        $lease->agents()->attach($request->input('agents'));
        return $this->response->item($lease, new LeaseTransformer())->setStatusCode(201);
    }

    /**
     * 修改房屋数据
     */
    public function update(UpdateLeaseRequest $request, Lease $lease)
    {
        $lease->fill($request->all());
        $lease->save();
        if ($request->has('property_type')) {
            $lease->propertyType()->sync($request->input('property_type'));
        }
        if ($request->has('agents')) {
            $lease->agents()->sync($request->input('agents'));
        }
        return $this->response->item($lease, new LeaseTransformer());
    }

    /**
     * 软删除租赁房屋数据
     */
    public function destroy(Lease $lease)
    {
        $lease->delete();
        return $this->response->noContent();
    }
}
