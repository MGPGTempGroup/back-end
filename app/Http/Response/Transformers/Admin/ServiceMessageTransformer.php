<?php

namespace App\Http\Response\Transformers\Admin;

use App\ServiceMessage;
use League\Fractal\TransformerAbstract;

class ServiceMessageTransformer extends TransformerAbstract
{
    public function transform(ServiceMessage $serviceMessage)
    {
        return [
            'id' => $serviceMessage->id,
            'name' => $serviceMessage->name,
            'surname' => $serviceMessage->surname,
            'phone' => $serviceMessage->phone,
            'comments' => $serviceMessage->comments,
            'identity_id' => $serviceMessage->identity_id,
            'identity' => $serviceMessage->identity,
            'service_id' => $serviceMessage->service_id,
            'remote_address' => $serviceMessage->remote_address,
            'created_at' => $serviceMessage->created_at->toDateTimeString(),
            'updated_at' => $serviceMessage->updated_at->toDateTimeString(),
        ];
    }
}
