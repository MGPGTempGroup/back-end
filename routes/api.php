<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'CORS']
], function ($api) {
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

            // 管理账户相关
            $api->get('admin-users/current', 'AdminUserController@show');
            $api->delete('authorizations/current', 'AuthorizationsController@logout');
            $api->get('admin-users/current/notifications', 'AdminUserController@notifications');

            // 服务相关
            $api->resource('services', 'ServiceController', [
                'only' => ['update', 'show', 'index']
            ]);
            $api->post('services/{service}/contents', 'ServiceController@storeContent');
            $api->get('service/testimonials', 'ServiceTestimonialController@index');
            $api->patch('service/testimonials/{serviceTestimonial}', 'ServiceTestimonialController@update');
            $api->delete('service/testimonials/{serviceTestimonial}', 'ServiceTestimonialController@destroy');

            // 服务领域相关
            $api->post('service-areas', 'ServiceController@createServiceArea');
            $api->get('service-areas', 'ServiceController@showServiceAreas');
            $api->get('service-areas/{serviceArea}', 'ServiceController@showServiceArea');
            $api->patch('service-areas/{serviceArea}', 'ServiceController@updateServiceArea');
            $api->delete('service-areas/{serviceArea}', 'ServiceController@destroyServiceArea');

            // 客户服务留言相关
            $api->get('services/{service}/messages', 'ServiceMessageController@show');
            $api->get('service-messages', 'ServiceMessageController@index');
            $api->delete('service-messages/{serviceMessage}', 'ServiceMessageController@delete');

            // 客户管理相关
            $api->resource('customers', 'CustomerController');
            $api->get('customers/{customer}/remarks', 'CustomerRemarkController@index');
            $api->post('customers/{customer}/remarks', 'CustomerRemarkController@store');
            $api->patch('customer-remarks/{customerRemark}', 'CustomerRemarkController@update')->middleware('can:update,customerRemark');
            $api->delete('customer-remarks/{customerRemark}', 'CustomerRemarkController@destroy')->middleware('can:softDelete,customerRemark');

            // 公司信息相关
            $api->get('company/info', 'CompanyInfoController@show');
            $api->patch('company/info', 'CompanyInfoController@update');

            // 公司成员相关
            $api->get('company/members', 'CompanyMemberController@index');
            $api->post('company/members', 'CompanyMemberController@store');
            $api->get('company/members/{companyMember}', 'CompanyMemberController@show');
            $api->patch('company/members/{companyMember}', 'CompanyMemberController@update');
            $api->delete('company/members/{companyMember}', 'CompanyMemberController@destroy');

            // 公司职位/部门相关
            $api->get('company/positions', 'CompanyMemberPositionController@index');
            $api->post('company/departments/{companyDepartment}/positions', 'CompanyMemberPositionController@batchStore');
            $api->patch('company/positions/{companyMemberPosition}', 'CompanyMemberPositionController@update');
            $api->delete('company/positions/{companyMemberPosition}', 'CompanyMemberPositionController@destroy');
            $api->get('company/departments', 'CompanyMemberPositionController@showDepartments');
            $api->post('company/departments', 'CompanyMemberPositionController@createDepartment');
            $api->patch('company/departments/{companyDepartment}', 'CompanyMemberPositionController@updateDepartment');
            $api->delete('company/departments/{companyDepartment}', 'CompanyMemberPositionController@destroyDepartment');

            // 项目管理
            $api->resource('projects', 'ProjectController');

            // 物业业主相关
            $api->resource('property-owners', 'PropertyOwnerController');

            // 物业类型相关
            $api->resource('property-types', 'PropertyTypeController', [
                'only' => ['index']
            ]);

            // 产品类型相关
            $api->resource('product-types', 'ProductTypeController', [
                'only' => ['index']
            ]);

            // 出售房屋相关
            $api->resource('residences', 'ResidenceController');
            $api->get('residences/{residence}/remarks', 'ResidenceRemarkController@index');
            $api->get('residences/{residence}/inspections', 'ResidenceController@inspections');
            $api->post('residences/{residence}/remarks', 'ResidenceRemarkController@store');
//            $api->patch('residence-remark/{residenceRemark}', 'ResidenceRemarkController@update')->middleware('can:update,residenceRemark');
//            $api->delete('residence-remark/{residenceRemark}', 'ResidenceRemarkController@destroy')->middleware('can:softDelete,residenceRemark');

            // 租赁房屋相关
            $api->resource('leases', 'LeaseController');
            $api->get('leases/{lease}/remarks', 'LeaseRemarkController@index');
            $api->get('leases/{lease}/inspections', 'LeaseController@inspections');
            $api->post('leases/{lease}/remarks', 'LeaseRemarkController@store');
//            $api->patch('lease-remarks/{leaseRemark}', 'LeaseRemarkController@update')->middleware('can:update,leaseRemark');
//            $api->delete('lease-remarks/{leaseRemark}', 'LeaseRemarkController@destroy')->middleware('can:softDelete,leaseRemark');

            // 房屋预约相关
            $api->get('inspections', 'HouseInspectionController@index');
            $api->patch('inspections/{houseInspection}/follow', 'HouseInspectionController@followUp');
            $api->delete('inspections/{houseInspection}', 'HouseInspectionController@destroy');

            // Industry Update 文章相关
            $api->resource('industry-updates', 'IndustryUpdateController');

            // 媒体文件上传
            $api->post('images', 'MediaFileController@uploadImage');
            $api->get('images/{key}', 'MediaFileController@showImage');
            $api->post('videos/slice-upload', 'MediaFileController@sliceUploadVideo');
            $api->post('videos/slice-upload-key', 'MediaFileController@createUploadVideoKey');
            $api->post('pdfs', 'MediaFileController@uploadPDF');

            // 应用统计相关
            $api->get('statistics', 'ApplicationStatisticsController@getAllStatistics');
            $api->get('statistics/past-30-days', 'ApplicationStatisticsController@getPast30DaysStatistics');
            $api->get('statistics/past-12-months', 'ApplicationStatisticsController@getPast12MonthsStatistics');

            // 备注数据
            $api->get('remarks', 'RemarkController@index');
            $api->post('remarks', 'RemarkController@store');
//            $api->post()
        });
    });

    // foreground
    $api->group([
        'namespace' => 'Home'
    ], function ($api) {

        // 房屋预约
        $api->post('residences/{residence}/inspections', 'HouseInspectionController@storeResidenceInspection');
        $api->post('leases/{lease}/inspections', 'HouseInspectionController@storeLeaseInspection');

        $api->get('customer-service/dialogue/{dialogueId}', 'CustomerServiceController@subscribeDialogue');
        $api->post('customer-service/dialogue', 'CustomerServiceController@createDialogue');
        $api->post('customer-service/dialogue/{dialogueId}/messages', 'CustomerServiceController@publishMessage');
    });
});
