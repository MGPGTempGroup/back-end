<?php

namespace App\Providers;

use API;
use App\CustomerLeaveMessage;
use App\HouseInspection;
use App\Observers\CustomerLeaveMessageObserver;
use App\Observers\HouseInspectionObserver;
use App\Observers\ServiceMessageObserver;
use App\ServiceMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 设定默认字符长度限制，解决utf8mb4最大字符问题
        Schema::defaultStringLength(191);

        // 模型观察者
        HouseInspection::observe(HouseInspectionObserver::class);
        ServiceMessage::observe(ServiceMessageObserver::class);
        CustomerLeaveMessage::observe(CustomerLeaveMessageObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });
        API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, 'Forbidden action.');
        });
        API::error(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception) {
            if ($exception->getPrevious() instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'login_again' => true, // 代表需要重新登录
                    'message' => 'Token has expired.'
                ])->setStatusCode(401);
            }
        });
    }
}
