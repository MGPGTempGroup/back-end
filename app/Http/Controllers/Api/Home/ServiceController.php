<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Response\Transformers\Home\ServiceContentTransformer;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function show(Service $service)
    {
        if (! ($content = $service->content)) {
            abort(404);
        }

        return $this->response->item($content, new ServiceContentTransformer());
    }
}
