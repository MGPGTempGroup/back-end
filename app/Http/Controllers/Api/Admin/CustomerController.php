<?php

namespace App\Http\Controllers\Api\Admin;

use App\Customer;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Response\Transformers\Admin\CustomerTransformer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{

    /**
     * 创建客户
     */
    public function store(CreateCustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();
        return $this->response->item($customer, new CustomerTransformer());
    }

}
