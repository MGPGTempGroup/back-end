<?php

namespace App\Http\Controllers\Api\Admin;

use App\MediaFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;

class MediaFileController extends Controller
{
    /**
     * 上传图片
     */
    public function uploadImage(Request $request, MediaFile $mediaFile)
    {
        $file = $request->file('images');

        // 上传时是否出现错误
        if (! $file->isValid()) $this->response->errorInternal('Upload failed.');

        $path = $file->store('/images', 'public');

        $mediaFile->fill([
            'path' => $path,
            'key' => md5(microtime() . mt_rand(0, 300) . $file->extension()),
            'mime_type' => $file->getMimeType(),
            'suffix' => $file->extension()
        ]);
        $mediaFile->save();

        return $this->response->created();
    }

}
