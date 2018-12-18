<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\ServiceArea;

class ServiceAreaTransformer extends TransformerAbstract
{
    public function transform(ServiceArea $serviceArea)
    {
        return [
            'id' => $serviceArea->id,
            'name' => $serviceArea->name,
            'picture' => $serviceArea->picture,
            'top_picture' => $serviceArea->top_picture,
            'introduction' => $serviceArea->introduction,
            'created_at' => $serviceArea->created_at->toDateTimeString(),
            'updated_at' => $serviceArea->updated_at->toDateTimeString()
        ];
    }
}
