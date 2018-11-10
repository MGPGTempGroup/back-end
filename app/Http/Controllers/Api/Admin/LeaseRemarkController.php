<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateLeaseRemarkRequest;
use App\Http\Requests\Admin\UpdateLeaseRemarkRequest;
use App\Http\Response\Transformers\Admin\LeaseRemarkTransformer;
use App\LeaseRemark;
use App\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaseRemarkController extends Controller
{

    /**
     * 获取某一个租赁房屋数据备注列表
     */
    public function index(Lease $lease)
    {
        $LeaseRemarksRelation = $lease->remarks();
        $remarks = $this->buildEloquentBuilderThroughQs($LeaseRemarksRelation)->paginate();
        return $this->response->paginator($remarks, new LeaseRemarkTransformer());
    }

    /**
     * 存储租赁房屋备注数据
     */
    public function store(CreateLeaseRemarkRequest $request, LeaseRemark $leaseRemark, $lease)
    {
        if(! Lease::where('id', $lease)->exists()) return $this->response->errorNotFound();

        $leaseRemark->fill($request->all());
        $leaseRemark->lease_id = (int) $lease;
        $leaseRemark->save();

        return $this->response->item($leaseRemark, new LeaseRemarkTransformer());
    }

    /**
     * 修改租赁房屋备注数据
     */
    public function update(UpdateLeaseRemarkRequest $request, LeaseRemark $leaseRemark)
    {
        $leaseRemark->content = $request->input('content');
        $leaseRemark->save();

        return $this->response->item($leaseRemark, new LeaseRemarkTransformer());
    }

    /**
     * 删除租赁房屋备注数据
     */
    public function destroy(LeaseRemark $leaseRemark)
    {
        $leaseRemark->delete();
        return $this->response->noContent();
    }

}
