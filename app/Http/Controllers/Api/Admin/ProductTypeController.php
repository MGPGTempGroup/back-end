<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Response\Transformers\Admin\ProductTypeTransformer;
use App\ProductType;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{
    /**
     * 展示产品类别列表
     */
    public function index(ProductType $productType)
    {
        $productTypes = $productType->get();
        return $this->response->collection($productTypes, new ProductTypeTransformer());
    }
}
