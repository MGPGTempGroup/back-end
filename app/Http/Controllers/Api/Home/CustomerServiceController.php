<?php

namespace App\Http\Controllers\Api\Home;

use App\CustomerDialogue;
use App\Http\Requests\Home\CreateDialogueMessageRequest;
use App\Http\Requests\Home\CreateDialogueRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Cache;

/**
 * 消息通信
 * 注：dialogue_id 等同于 为对话生成的guid
 * 当前虚拟主机不支持Swoole拓展或workman的相关依赖并且只分配80端口...
 * 故使用h5 sse实现
 */
class CustomerServiceController extends Controller
{

    /**
     * 创建一个客户对话
     */
    public function createDialogue(CreateDialogueRequest $request)
    {
        // 生成guid作为本次对话唯一标识
        $guid = $this->generateGUID();

        // 将此次对话相关数据存储到缓存
        $cache = $this->getCache();
        $cache->put($this->getDialogueCacheKey($guid), [
            'customer_info' => [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ],
            'messages' => [], // 消息列表
            'guid' => $guid,
            'created_at' => now()->toDateTimeString(),
        ], 60 * 15);

        // 响应客户端对话id
        return $this->response->array([
            'dialogue_id' => $guid
        ])->setStatusCode(201)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * 通过对话id连续输出最新消息流数据
     */
    public function subscribeDialogue(Request $request, $dialogueId)
    {
        $cache = $this->getCache();
        $cacheKey = $this->getDialogueCacheKey($dialogueId);
        if (! $cache->has($cacheKey)) return $this->response->errorNotFound();

        // 通过Symfony的StreamedResponse构建流响应
        $response = new StreamedResponse(function () use ($dialogueId) {

            $unpushedMessages = $this->getUnpushedMessages($dialogueId, 'admin');

            $this->outputStreamData($unpushedMessages, $dialogueId);

            sleep(2);
        });
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');

        return $response;
    }

    /**
     * 客户发表消息（之前必须调用createDialogue方法）
     */
    public function publishMessage(CreateDialogueMessageRequest $request, $dialogueId)
    {
        $cache = $this->getCache();
        $cacheKey = $this->getDialogueCacheKey($dialogueId);
        if (! $dialogueData = $cache->get($cacheKey)) return $this->response->errorNotFound();

        $dialogueData['messages'][] = [
            'publisher' => 'customer',
            'content' => $request->input('content'),
            'created_at' => now()->toDateTimeString(),
            'pushed' => false
        ];

        $cache->put($cacheKey, $dialogueData, 60 * 15);

        return $this->response->created();
    }

    /**
     * 获取未发送的消息
     */
    public function getUnpushedMessages($dialogueId, $identity = 'customer')
    {
        $cache = $this->getCache();
        $cacheKey = $this->getDialogueCacheKey($dialogueId);

        $dialogueData = $cache->get($cacheKey);
        $messages = $dialogueData['messages'];
        krsort($messages);

        // 遍历该对话消息列表：如果存在未发送的消息则放入未发送消息列表
        $unsendMessages = [];
        foreach ($messages as $key => &$message) {
            if ($message['publisher'] === $identity && !$message['pushed']) {
                $message['pushed'] = true;
                array_unshift($unsendMessages, $message); // 消息列表经过倒序排序，故需要插入到数组头部
            }
        }

        // 更新缓存数据
        ksort($messages);
        $dialogueData['messages'] = $messages;
        $cache->put($cacheKey, $dialogueData, 60 * 15);

        return $unsendMessages;
    }

    /**
     * 输出流数据
     */
    public function outputStreamData(array $data, $dialogueId)
    {
        echo 'id: ' . $dialogueId . "\n";
        echo 'data: ' . json_encode($data);
        echo "\n\n";
        ob_flush();
        flush();
    }

    /**
     * 生成guid作为每个对话的唯一标识
     */
    public function generateGUID()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8) . $hyphen
            .substr($charid, 8, 4) . $hyphen
            .substr($charid,12, 4) . $hyphen
            .substr($charid,16, 4) . $hyphen
            .substr($charid,20,12);
        return $uuid;
    }

    public function getCache()
    {
        return Cache::store('database');
    }

    public function getDialogueCacheKey($guid)
    {
        return 'customer_dialogue_' . $guid;
    }
}
