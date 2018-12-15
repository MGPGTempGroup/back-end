<?php

namespace App\Http\Response\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Service;

class ServiceTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'historicalContents'
    ];

    protected $defaultIncludes = [
        'members', 'content'
    ];

    public function transform(Service $service)
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'created_at' => $service->created_at->toDateTimeString(),
            'updated_at' => $service->updated_at->toDateTimeString()
        ];
    }

    public function includeMembers(Service $service)
    {
        if ($members = $service->members) {
            return $this->collection($members, new CompanyMemberTransformer());
        }
        return $this->null();
    }

    public function includeContent(Service $service)
    {
        if(! $content = $service->content) return $this->null();
        return $this->item($content, new ServiceContentTransformer());
    }

    public function includeHistoricalContents(Service $service)
    {
        $contents = $service
            ->historicalContents()
            ->orderBy('id', 'DESC')
            ->limit(20)
            ->get();
        if (! $contents) return $this->null();
        return $this->collection($contents, new ServiceContentTransformer());
    }
}
