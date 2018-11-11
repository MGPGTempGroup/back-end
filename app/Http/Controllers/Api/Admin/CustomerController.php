<?php

namespace App\Http\Controllers\Api\Admin;

use App\Customer;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Http\Response\Transformers\Admin\CustomerTransformer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{

    /**
     * 客户列表
     */
    public function index(Customer $customer)
    {
        $customers = $this->buildEloquentBuilderThroughQs($customer)->paginate();
        return $this->response->paginator($customers, new CustomerTransformer());
    }

    /**
     * 创建客户
     */
    public function store(CreateCustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();
        return $this->response->item($customer, new CustomerTransformer());
    }

    /**
     * 修改客户信息
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();
        return $this->response->item($customer, new CustomerTransformer());
    }

}
