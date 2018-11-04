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
        $api->patch('service-areas/{serviceArea}', 'ServiceController@updateServiceArea');
        $api->delete('service-areas/{serviceArea}', 'ServiceController@destroyServiceArea');

        // 公司信息相关
        $api->get('company/info', 'CompanyInfoController@show');
        $api->patch('company/info', 'CompanyInfoController@update');

        $api->resource('company/members', 'CompanyMemberController');

        $api->get('company/positions', 'CompanyMemberPositionController@index');
        $api->post('company/positions', 'CompanyMemberPositionController@store');
        $api->patch('company/positions/{companyMemberPosition}', 'CompanyMemberPositionController@update');
        $api->delete('company/positions/{companyMemberPosition}', 'CompanyMemberPositionController@destroy');

        $api->get('company/departments', 'CompanyMemberPositionController@showDepartments');
        $api->post('company/departments', 'CompanyMemberPositionController@createDepartment');
        $api->patch('company/departments/{companyDepartment}', 'CompanyMemberPositionController@updateDepartment');
        $api->delete('company/departments/{companyDepartment}', 'CompanyMemberPositionController@destroyDepartment');
    });
});
