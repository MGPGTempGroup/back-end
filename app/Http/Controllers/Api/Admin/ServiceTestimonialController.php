<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Response\Transformers\Admin\ServiceTestimonialTransformer;
use App\ServiceTestimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceTestimonialController extends Controller
{
    public function index(ServiceTestimonial $serviceTestimonial)
    {
        $testimonials = $this->buildEloquentQueryThroughQs($serviceTestimonial)->paginate();
        return $this->response->paginator($testimonials, new ServiceTestimonialTransformer());
    }

    public function update(Request $request, ServiceTestimonial $serviceTestimonial)
    {
        $serviceTestimonial->is_show = (int) (bool) $request->input('is_show');
        $serviceTestimonial->save();
        return $this->response->item($serviceTestimonial, new ServiceTestimonialTransformer());
    }

    public function destroy(ServiceTestimonial $serviceTestimonial)
    {
        $serviceTestimonial->delete();
        return $this->response->noContent();
    }
}
