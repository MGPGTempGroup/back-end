<?php

namespace App\Http\Response\Transformers\Admin;

use App\CustomerLeaveMessage;
use League\Fractal\TransformerAbstract;

class CustomerLeaveMessageTransformer extends TransformerAbstract
{
    public function transform(CustomerLeaveMessage $customerLeaveMessage)
    {
        return [
            'id' => $customerLeaveMessage->id,
            'name' => $customerLeaveMessage->name,
            'email' => $customerLeaveMessage->email,
            'messages' => $customerLeaveMessage->messages,
            'created_at' => $customerLeaveMessage->created_at->toDateTimeString(),
            'updated_at' => $customerLeaveMessage->updated_at->toDateTimeString()
        ];
    }
}
