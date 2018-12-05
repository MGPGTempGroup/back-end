<?php

namespace App\Http\Response\Transformers\Admin;

use App\ProductType;
use League\Fractal\TransformerAbstract;

class ProductTypeTransformer extends TransformerAbstract
{
    public function transform(ProductType $productType)
    {
        return [
            'id' => $productType->id,
            'name' => $productType->name,
            'created_at' => $productType->created_at->toDateTimeString(),
            'updated_at' => $productType->updated_at->toDateTimeString()
        ];
    }
}
