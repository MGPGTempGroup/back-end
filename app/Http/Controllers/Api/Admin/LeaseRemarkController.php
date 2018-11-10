<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateLeaseRemarkRequest;
use App\Http\Response\Transformers\Admin\LeaseRemarkTransformer;
use App\LeaseRemark;
use App\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaseRemarkController extends Controller
{

    /**
     * 获取某一个租赁房屋数据留言列表
     */
    public function index(Lease $lease)
    {
        $LeaseRemarksRelation = $lease->remarks();
        $remarks = $this->buildEloquentBuilderThroughQs($LeaseRemarksRelation)->paginate();
        return $this->response->paginator($remarks, new LeaseRemarkTransformer());
    }

    /**
     * 存储租赁房屋留言数据
     */
    public function store(CreateLeaseRemarkRequest $request, LeaseRemark $leaseRemark, $lease)
    {
        if(! Lease::where('id', $lease)->exists()) return $this->response->errorNotFound();

        $leaseRemark->fill($request->all());
        $leaseRemark->lease_id = (int) $lease;
        $leaseRemark->save();

        return $this->response->item($leaseRemark, new LeaseRemarkTransformer());
    }

}
