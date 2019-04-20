<?php

namespace App\Http\Response\Transformers\Home;

use App\ServiceContent;
use League\Fractal\TransformerAbstract;

class ServiceContentTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['members'];

    public function transform(ServiceContent $serviceContent)
    {
        return [
            'content' => $serviceContent->content,
            'broadcast_pictures' => $serviceContent->broadcast_pictures
        ];
    }

    public function includeMembers(ServiceContent $serviceContent)
    {
        $members = $serviceContent->members;

        if ($members) {
            return $this->collection($members, new CompanyMemberTransformer);
        } else {
            return $this->primitive(new \stdClass());
        }
    }
}
