<?php

namespace App\Http\Controllers\Api\Admin;

use App\HouseInspection;
use App\ServiceMessage;
use App\Residence;
use App\Lease;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ApplicationStatisticsController extends Controller
{

    /**
     * 获取全部应用统计数据
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAllStatistics() {

        $cache = cache()->store('database');

        define('CACHE_EXPIRED', 30); // 缓存过期时间
        $statisticsData = $cache->remember('app_all_statistics', CACHE_EXPIRED, function () {
            // 客户留言统计
            $customerCommentsCount = ServiceMessage::count();
            $currentWeekCustomerCommentsCount = $this->fetchCurrentWeekCount('service_messages');

            // 查询租赁房屋与出售房屋的预约统计
            $houseInspectionsCount = HouseInspection::count();
            $currentWeekHouseInspectionsCount = $this->fetchCurrentWeekCount('house_inspections');

            // stdClass实例代表一个无任何属性方法的对象
            // 目的是为了在响应JSON数据时如果碰到空数组将不会被json_encode成"[]"而是一个"{}"
            // 解决的错误： json_encode(['a' => 1]) -> { "a": 1 } 而 json_encode([]) -> [] 应为 {}
            // 如果碰到空数组则响应空对象
            $emptyObject = new \stdClass;
            return [
                'customer_comments_count' => $customerCommentsCount,
                'current_week_customer_comments_count' => $currentWeekCustomerCommentsCount ?: $emptyObject,
                'house_inspections_count' => $houseInspectionsCount,
                'current_week_house_inspections_count' => $currentWeekHouseInspectionsCount ?: $emptyObject
            ];
        });
        return $this->response->array($statisticsData);
    }

    /**
     * 取得当前周每日数据量
     */
    protected function fetchCurrentWeekCount($table) {
        return DB::table($table)
            ->selectRaw('DATE_FORMAT(created_at, \'%Y-%m-%d\') as day, count(*) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))
            ->groupBy('day')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->day => $item->total];
            })
            ->toArray();
    }
}
