<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreatePropertyOwnerRequest;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\UpdatePropertyOwnerRequest;
use App\Http\Response\Transformers\Admin\PropertyOwnerTransformer;
use App\PropertyOwner;

class PropertyOwnerController extends Controller
{
    /**
     * 创建物业业主
     */
    public function store(CreatePropertyOwnerRequest $request, PropertyOwner $propertyOwner)
    {
        $propertyOwner->fill($request->all());
        $propertyOwner->save();
        return $this->response->item($propertyOwner, new PropertyOwnerTransformer())->setStatusCode(201);
    }

    /**
     * 修改物业业主
     */
    public function update(UpdatePropertyOwnerRequest $request, PropertyOwner $propertyOwner)
    {
        $propertyOwner->fill($request->all());
        $propertyOwner->save();
        return $this->response->item($propertyOwner, new PropertyOwnerTransformer());
    }
}
