<?php

namespace App\Http\Controllers\Api\Admin;

use App\Customer;
use App\CustomerRemark;
use App\Http\Requests\Admin\CreateCustomerRemarkRequest;
use App\Http\Requests\Admin\UpdateCustomerRemarkRequest;
use App\Http\Response\Transformers\Admin\CustomerRemarkTransformer;
use App\Http\Controllers\Controller;

class CustomerRemarkController extends Controller
{

    /**
     * 获取客户备注列表
     */
    public function index(Customer $customer)
    {
        $customerRemarksRelation = $customer->remarks();
        $remarks = $this->buildEloquentBuilderThroughQs($customerRemarksRelation)->paginate();

        return $this->response->paginator($remarks, new CustomerRemarkTransformer());
    }

    /**
     * 创建客户备注
     */
    public function store(CreateCustomerRemarkRequest $request, Customer $customer, CustomerRemark $customerRemark)
    {
        $customerRemark->fill([
            'content' => $request->input('content'),
            'admin_user_id' => $this->user()->id
        ]);
        $customer->remarks()->save($customerRemark);

        return $this->response->item($customerRemark, new CustomerRemarkTransformer());
    }

    /**
     * 修改客户备注
     */
    public function update(UpdateCustomerRemarkRequest $request, CustomerRemark $customerRemark)
    {
        $customerRemark->fill($request->all());
        $customerRemark->save();

        return $this->response->item($customerRemark, new CustomerRemarkTransformer());
    }

}
