<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreatePropertyOwnerRequest;
use App\Http\Controllers\Controller;

use App\Http\Response\Transformers\Admin\PropertyOwnerTransformer;
use App\PropertyOwner;

class PropertyOwnerController extends Controller
{
    public function store(CreatePropertyOwnerRequest $request, PropertyOwner $propertyOwner)
    {
        $propertyOwner->fill($request->all());
        $propertyOwner->save();
        return $this->response->item($propertyOwner, new PropertyOwnerTransformer());
    }
}
