<?php

namespace App\Providers;

use App\HouseInspection;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });
    }
}
