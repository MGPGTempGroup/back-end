<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Service;

class ServiceTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'members'
    ];

    public function transform(Service $service)
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'broadcast_pictures' => $service->broadcast_pictures,
            'content' => $service->content,
            'created_at' => $service->created_at->toDateTimeString(),
            'updated_at' => $service->updated_at->toDateTimeString()
        ];
    }

    public function includeMembers(Service $service)
    {
        return $this->collection($service->members, new CompanyMemberTransformer());
    }
}
