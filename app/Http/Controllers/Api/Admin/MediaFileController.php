<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\CreateSliceUploadVideoKeyRequest;
use App\Http\Requests\Admin\UploadSliceVideoFileRequest;
use App\MediaFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Cache;

class MediaFileController extends Controller
{

    // 默认所使用的FileSystem磁盘
    protected $disk = 'public';

    // 视频文件分片上传过期时间 (s)
    protected $sliceFileExpired = 1200;

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
        $key = $this->generateMediaFileKey();

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

    /**
     * 获取分片上传视频的key
     *
     * 思路：
     * 此接口在进行分片上传之前必须调用，客户端请求此接口所带参数必须包含：
     * a. 切片数量
     * b. 文件扩展名
     * 之后生成一个随机Key，用作Redis存储，作为本次分片上传的标识
     * 接口响应这个key值，接下来的分片上传过程中，每个文件片的上传必须要带着这个key
     */
    public function createUploadVideoKey(CreateSliceUploadVideoKeyRequest $request)
    {

        // 生成key
        $key = str_random(10) . mt_rand(0, 1024) . time();

        // Redis
        $redisKey = 'slice_uploading_file_' . $key;

        $redis = Cache::store('redis');
        $redis->put($redisKey, [
            'slices' => $request->slices, // 切片数量
            'extension' => $request->extension, // 文件扩展名
            'slice_files' => [] // 切片文件相关元数据存储
        ], $this->sliceFileExpired);

        return $this->response->array([
            'key' => $key
        ])->setStatusCode(201);
    }

    /**
     * 视频分片上传接口
     * 请求此接口必须要带着获取的视频上传key
     * todo: 验证片大小等...
     */
    public function sliceUploadVideo(UploadSliceVideoFileRequest $request)
    {

        $cache = Cache::store('redis');
        $cacheKey = 'slice_uploading_file_' . $request->key;

        // 判断Key是否存在或是否已过期
        if (! $sliceUploadMetaData = $cache->get($cacheKey)) {
            $this->response->errorBadRequest('Key does not exist.');
        }

        // 存储分片文件
        $file = $request->file('slice_file');
        $path = $file->store('/slice_files', $this->disk);

        // 存储当前分片相关元数据到缓存中
        $sliceUploadMetaData['slice_files'][$request->index] = [
            'path' => $path,
        ];
        $cache->put($cacheKey, $sliceUploadMetaData, $this->sliceFileExpired);

        // 是否完成
        if (! $request->done) {

            return $this->response->created();

        } else {

            $fileSys = Storage::disk($this->disk);

            // 取得对应分片文件元数据并对其按照index排序
            $sliceFiles = $sliceUploadMetaData['slice_files'];
            ksort($sliceFiles);

            // 生成合并后的文件名以及路径
            $mergedFilename  = str_random(12) . mt_rand(0, 191) . time() . '.' .$sliceUploadMetaData['extension'];
            $mergedFilepath = 'videos/' . $mergedFilename;

            // 合并分片文件
            foreach ($sliceFiles as $key => $val) {
                $fileSys->append($mergedFilepath, $fileSys->get($val['path']), null);
            }

            MediaFile::create([
                'key' => $this->generateMediaFileKey(),
                'path' => $mergedFilepath,
                'mime_type' => $fileSys->mimeType($mergedFilepath),
                'suffix' => $sliceUploadMetaData['extension'],
                'media_file_type' => 1, // 视频
                'storage_mode' => 0 // 本地
            ]);

            // 分片上传完成，销毁缓存key
            $cache->forget($cacheKey);

            return $this->response->array([
                'md5' => md5_file($fileSys->path($mergedFilepath)), // 文件的md5码
                'key' => $this->generateMediaFileKey(),
            ])->setStatusCode(201);

        }

    }

    /**
     * 生成媒体文件存入数据库时的key
     */
    public function generateMediaFileKey()
    {
        return str_random(24);
    }

}
