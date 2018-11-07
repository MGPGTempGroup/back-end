<?php

namespace App\Http\Controllers\Api\Admin;

use App\MediaFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;

class MediaFileController extends Controller
{

    // 默认所使用的FileSystem磁盘
    protected $disk = 'public';

    /**
     * 展示图片
     */
    public function showImage(Request $request, MediaFile $mediaFile)
    {
        if (! $path = $mediaFile->select('path')->images($request->key)->pluck('path')->first()) {
            return $this->response->errorNotFound();
        }
        $fullpath = Storage::disk($this->disk)->path($path);
        return response()->file($fullpath);
    }

    /**
     * 上传图片
     */
    public function uploadImage(Request $request, MediaFile $mediaFile)
    {
        $file = $request->file('images');

        // 上传时是否出现错误
        if (! $file->isValid()) $this->response->errorInternal('Upload failed.');

        $path = $file->store('/images', $this->disk);
        $key = md5(microtime() . mt_rand(0, 300) . $file->extension());

        $mediaFile->fill([
            'path' => $path,
            'key' => $key,
            'mime_type' => $file->getMimeType(),
            'suffix' => $file->extension()
        ]);
        $mediaFile->save();

        return $this->response->array([
            'key' => $key
        ])->setStatusCode(201);
    }

}
