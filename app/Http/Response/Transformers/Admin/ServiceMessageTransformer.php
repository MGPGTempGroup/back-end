<?php

namespace App\Http\Response\Transformers\Admin;

use App\ServiceMessage;
use League\Fractal\TransformerAbstract;

class ServiceMessageTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['remarks'];

    protected $defaultIncludes = ['service'];

    public function transform(ServiceMessage $serviceMessage)
    {
        return [
            'id' => $serviceMessage->id,
            'name' => $serviceMessage->name,
            'surname' => $serviceMessage->surname,
            'email' => $serviceMessage->email,
            'phone' => $serviceMessage->phone,
            'wechat' => $serviceMessage->wechat,
            'comments' => $serviceMessage->comments,
            'identity_id' => $serviceMessage->identity_id,
            'identity' => $serviceMessage->identity,
            'service_id' => $serviceMessage->service_id,
            'remote_address' => $serviceMessage->remote_address,
            'created_at' => $serviceMessage->created_at->toDateTimeString(),
            'updated_at' => $serviceMessage->updated_at->toDateTimeString(),
        ];
    }

    public function includeService(ServiceMessage $serviceMessage)
    {
        return $this->item($serviceMessage->service, new ServiceTransformer());
    }

    public function includeRemarks(ServiceMessage $serviceMessage)
    {
        $remarks = $serviceMessage->remarks;
        if ($remarks) {
            return $this->collection($remarks, new RemarkTransformer());
        }
        return $this->null();
    }

}
