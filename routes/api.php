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
        'namespace' => 'Admin',
        'middleware' => ['defineAPIGuardProvider:admin_users']
    ], function ($api) {

        // 登录
        $api->post('authorizations', 'AuthorizationsController@authenticate');

        $api->group([
            'middleware' => ['api.auth']
        ], function ($api) {

            // 账户登出接口
            $api->delete('authorizations/current', 'AuthorizationsController@logout');

            // 服务内容相关
            $api->get('services/{service}', 'ServiceController@show');
            $api->patch('services/{service}', 'ServiceController@update');
            $api->post('service-areas', 'ServiceController@createServiceArea');
            $api->get('service-areas', 'ServiceController@showServiceAreas');
            $api->get('service-areas/{serviceArea}', 'ServiceController@showServiceArea');
            $api->patch('service-areas/{serviceArea}', 'ServiceController@updateServiceArea');
            $api->delete('service-areas/{serviceArea}', 'ServiceController@destroyServiceArea');
            $api->get('services/{service}/messages', 'ServiceMessageController@show');
            $api->get('service-messages', 'ServiceMessageController@index');
            $api->delete('service-messages/{serviceMessage}', 'ServiceMessageController@delete');

            // 客户管理相关
            $api->resource('customers', 'CustomerController');
            $api->get('customers/{customer}/remarks', 'CustomerRemarkController@index');
            $api->post('customers/{customer}/remarks', 'CustomerRemarkController@store');

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

            // 物业业主相关
            $api->resource('property-owners', 'PropertyOwnerController');

            // 出售房屋
            $api->resource('residences', 'ResidenceController');
            $api->get('residences/{residence}/remarks', 'ResidenceRemarkController@index');
            $api->post('residences/{residence}/remarks', 'ResidenceRemarkController@store');
            $api->patch('residence-remark/{residenceRemark}', 'ResidenceRemarkController@update');
            $api->delete('residence-remark/{residenceRemark}', 'ResidenceRemarkController@destroy');

            // 租赁房屋
            $api->resource('leases', 'LeaseController');
            $api->get('leases/{lease}/remarks', 'LeaseRemarkController@index');
            $api->post('leases/{lease}/remarks', 'LeaseRemarkController@store');
            $api->patch('lease-remarks/{leaseRemark}', 'LeaseRemarkController@update');
            $api->delete('lease-remarks/{leaseRemark}', 'LeaseRemarkController@destroy');

            // 媒体文件上传
            $api->post('images', 'MediaFileController@uploadImage');
            $api->get('images/{key}', 'MediaFileController@showImage');
            $api->post('videos/slice-upload', 'MediaFileController@sliceUploadVideo');
            $api->post('videos/slice-upload-key', 'MediaFileController@createUploadVideoKey');
        });
    });
});
