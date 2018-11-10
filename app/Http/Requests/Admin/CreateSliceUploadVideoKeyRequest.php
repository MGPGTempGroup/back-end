<?php

namespace App\Http\Requests\Admin;

class CreateSliceUploadVideoKeyRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'slices' => 'required|numeric', // 切片数量
            'extension' => 'required|in:avi,flv,mpg,mov,mkv,mp4,txt' // 文件扩展名
        ];
    }
}
