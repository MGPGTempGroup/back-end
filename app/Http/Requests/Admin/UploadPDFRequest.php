<?php

namespace App\Http\Requests\Admin;

class UploadPDFRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'pdf' => 'bail|required|file|max:10240|mimetypes:application/pdf|'
        ];
    }
}
