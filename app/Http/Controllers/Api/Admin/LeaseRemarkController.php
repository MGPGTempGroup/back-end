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
     * 存储租赁房屋留言数据
     */
    public function store(CreateLeaseRemarkRequest $request, LeaseRemark $leaseRemark, $lease_id)
    {
        if(! Lease::where('id', $lease_id)->exists()) return $this->response->errorNotFound();

        $leaseRemark->fill($request->all());
        $leaseRemark->lease_id = (int) $lease_id;
        $leaseRemark->save();

        return $this->response->item($leaseRemark, new LeaseRemarkTransformer(), ['key' => 'user']);
    }

}
