<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\ServiceContent;

class ServiceContentTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'creator', 'modifier'
    ];

    public function transform(ServiceContent $serviceContent)
    {
        return [
            'id' => $serviceContent->id,
            'content' => $serviceContent->content,
            'broadcast_pictures' => $serviceContent->broadcast_pictures,
            'creator_id' => $serviceContent->creator_id,
            'modifier_id' => $serviceContent->modifier_id,
            'created_at' => $serviceContent->created_at->toDateTimeString(),
            'updated_at' => $serviceContent->updated_at->toDateTimeString()
        ];
    }

    public function includeCreator(ServiceContent $serviceContent)
    {
        return $this->item($serviceContent->creator, new AdminUserTransformer());
    }

    public function includeModifier(ServiceContent $serviceContent)
    {
        if (! $modifier = $serviceContent->modifier) return $this->null();
        return $this->item($modifier, new AdminUserTransformer());
    }
}
