<?php

namespace App\Http\Response\Transformers\Admin;

use App\ServiceTestimonial;
use League\Fractal\TransformerAbstract;

class ServiceTestimonialTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'identity'
    ];

    public function transform(ServiceTestimonial $serviceTestimonial)
    {
        return [
            'id' => $serviceTestimonial->id,
            'surname' => $serviceTestimonial->surname,
            'name' => $serviceTestimonial->name,
            'phone' => $serviceTestimonial->phone,
            'email' => $serviceTestimonial->email,
            'comment' => $serviceTestimonial->comment,
            'identity_id' => $serviceTestimonial->identity_id,
            'created_at' => $serviceTestimonial->created_at->toDateTimeString(),
            'updated_at' => $serviceTestimonial->updated_at->toDateTimeString(),
            'is_show' => $serviceTestimonial->is_show,
            'star_level' => $serviceTestimonial->star_level
        ];
    }

    public function includeIdentity(ServiceTestimonial $serviceTestimonial)
    {
        if ($identity = $serviceTestimonial->identity) {
            return $this->item($identity, new CustomerIdentityTransformer());
        }
        return $this->null();
    }
}
