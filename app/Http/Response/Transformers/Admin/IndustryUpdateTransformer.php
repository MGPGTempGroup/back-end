<?php

namespace App\Http\Response\Transformers\Admin;

use App\IndustryUpdate;
use League\Fractal\TransformerAbstract;

class IndustryUpdateTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'creator'
    ];

    public function transform(IndustryUpdate $industryUpdate)
    {
        return [
            'id' => $industryUpdate->id,
            'title' => $industryUpdate->title,
            'content' => $industryUpdate->content,
            'creator_id' => $industryUpdate->creator_id,
            'first_picture' => $industryUpdate->first_picture,
            'top_picture' => $industryUpdate->top_picture,
            'created_at' => $industryUpdate->created_at->toDateTimeString(),
            'updated_at' => $industryUpdate->updated_at->toDateTimeString()
        ];
    }

    public function includeCreator(IndustryUpdate $industryUpdate)
    {
        return $this->item($industryUpdate->creator, new AdminUserTransformer());
    }

}
