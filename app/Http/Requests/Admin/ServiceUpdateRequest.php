<?php

namespace App\Http\Requests\Admin;

class ServiceUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'bail|string',
            'broadcast_pictures' => 'bail|json' // todo: 验证json数据格式
        ];
    }
}
