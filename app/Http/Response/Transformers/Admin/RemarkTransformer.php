<?php

namespace App\Http\Response\Transformers\Admin;

use App\Remark;
use League\Fractal\TransformerAbstract;

class RemarkTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['creator'];

    public function transform(Remark $remark)
    {
        return [
            'id' => $remark->id,
            'content' => $remark->content,
            'come_from_type' => $remark->come_from_type,
            'come_from_id' => $remark->come_from_id,
            'creator_id' => $remark->creator_id,
            'created_at' => $remark->created_at->toDateTimeString(),
            'updated_at' => $remark->updated_at->toDateTimeString()
        ];
    }

    public function includeCreator(Remark $remark)
    {
        $creator = $remark->creator;
        return $creator ? $this->item($creator, new AdminUserTransformer()) : $this->null();
    }

}
