<?php

namespace App\Http\Controllers\Api\Admin;

use App\CustomerLeaveMessage;
use App\Http\Response\Transformers\Admin\CustomerLeaveMessageTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerLeaveMessageController extends Controller
{
    public function index(CustomerLeaveMessage $customerLeaveMessage)
    {
        $eloquentBuilder = $this->buildEloquentQueryThroughQs($customerLeaveMessage);
        $leaveMessages = $eloquentBuilder->paginate();
        return $this->response->paginator($leaveMessages, new CustomerLeaveMessageTransformer());
    }

    public function destroy(CustomerLeaveMessage $customerLeaveMessage)
    {
        try {
            $customerLeaveMessage->delete();
        } catch (\Exception $e) {
            // ...
        }
        return $this->response->noContent();
    }
}
