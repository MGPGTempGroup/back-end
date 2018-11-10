<?php

namespace App\Http\Requests\Admin;

class UploadSliceVideoFileRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'key' => 'required|string',
            'index' => 'required|numeric',
            'slice_file' => 'required|file'
        ];
    }
}
