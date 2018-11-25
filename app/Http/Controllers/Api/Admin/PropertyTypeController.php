<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Response\Transformers\Admin\PropertyTypeTransformer;
use App\PropertyType;
use App\Http\Controllers\Controller;

class PropertyTypeController extends Controller
{
    /**
     * 展示物业类型列表
     */
    public function index(PropertyType $propertyType)
    {
        $propertyTypes = $propertyType->get();
        return $this->response->collection($propertyTypes, new PropertyTypeTransformer());
    }
}
