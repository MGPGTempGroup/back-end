<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array'
],function ($api) {
    $api->get('test', function (Request $request) {
        return response([
            'msg' => 'ok'
        ]);
    });
});
