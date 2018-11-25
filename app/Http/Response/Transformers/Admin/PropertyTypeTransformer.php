<?php

namespace App\Http\Response\Transformers\Admin;

use App\PropertyType;
use League\Fractal\TransformerAbstract;

class PropertyTypeTransformer extends TransformerAbstract
{
    public function transform(PropertyType $propertyType)
    {
        return [
            'id' => $propertyType->id,
            'name' => $propertyType->name,
            'created_at' => $propertyType->created_at->toDateTimeString(),
            'updated_at' => $propertyType->updated_at->toDateTimeString()
        ];
    }
}
