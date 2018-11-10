<?php

namespace App\Http\Response\Transformers\Admin;

use App\ResidenceRemark;
use League\Fractal\TransformerAbstract;

class ResidenceRemarkTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'creator'
    ];

    public function transform(ResidenceRemark $residenceRemark)
    {
        return [
            'id' => $residenceRemark->id,
            'admin_user_id' => $residenceRemark->admin_user_id,
            'residence_id' => $residenceRemark->residence_id,
            'content' => $residenceRemark->content,
            'created_at' => $residenceRemark->created_at->toDateTimeString(),
            'updated_at' => $residenceRemark->updated_at->toDateTimeString()
        ];
    }

    public function includeCreator(ResidenceRemark $residenceRemark)
    {
        return $this->item($residenceRemark->creator, new AdminUserTransformer());
    }

}
