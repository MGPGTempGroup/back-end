<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateLeaseRequest;
use App\Http\Response\Transformers\Admin\LeaseTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lease;

class LeaseController extends Controller
{
    /**
     * 创建租赁房屋
     */
    public function store(CreateLeaseRequest $request, Lease $lease)
    {
        $lease->fill($request->all());
        $lease->save();

        return $this->response->item($lease, new LeaseTransformer());
    }
}
