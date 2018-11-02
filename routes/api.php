<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings']
],function ($api) {
    // background
    $api->group([
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ], function ($api) {
        // 登录
        $api->post('login', 'AuthorizationsController@authenticate');

        // 服务内容相关
        $api->get('services/{service}', 'ServiceController@show');
        $api->patch('services/{service}', 'ServiceController@update');
        $api->post('service-areas', 'ServiceController@createServiceArea');
        $api->get('service-areas', 'ServiceController@showServiceAreas');
        $api->get('service-areas/{serviceArea}', 'ServiceController@showServiceArea');
    });
});
