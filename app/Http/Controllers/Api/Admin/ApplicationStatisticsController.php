<?php

namespace App\Http\Controllers\Api\Admin;

use App\HouseInspection;
use App\ServiceMessage;
use App\Residence;
use App\Lease;
use App\Statistic;
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
    public function getAllStatistics(Statistic $statistic) {

        $cache = cache()->store('database');

        define('CACHE_EXPIRED', 60); // 缓存过期时间 min
        $statisticsData = $cache->remember('app_statistics', CACHE_EXPIRED, function () use ($statistic) {

            $statisticDataItemVal = [
                'total' => 0,
                'last_7_days' => [],
                'today' => 0
            ];
            // 要缓存的统计数据的结构
            $statisticsData = [
                'service_messages' => $statisticDataItemVal,
                'house_inspections' => $statisticDataItemVal,
                'page_view' => $statisticDataItemVal,
                'unique_visitor' => $statisticDataItemVal,
            ];

            // 查询出数据总计数： total
            $totalCountSelectSQL = [
                'sum(house_inspections) as hi_total',
                'sum(service_messages) as ss_total',
                'sum(page_view) as pv_total',
                'sum(unique_visitor) as uv_total'
            ];
            $totalCount = $statistic
                ->selectRaw(implode($totalCountSelectSQL, ','))
                ->first();
            $statisticsData['service_messages']['total'] = (int) $totalCount->ss_total;
            $statisticsData['house_inspections']['total'] = (int) $totalCount->hi_total;
            $statisticsData['page_view']['total'] = (int) $totalCount->pv_total;
            $statisticsData['unique_visitor']['total'] = (int) $totalCount->uv_total;

            // 查询最近7日数据计数：last 7 days
            $last7DaysCount = $statistic
                ->select(['house_inspections', 'service_messages', 'page_view', 'unique_visitor', 'date_created'])
                ->where('date_created', '>=', now()->subDays(7)->format('Y-m-d'))
                ->where('date_created', '<=', now()->format('Y-m-d'))
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->date_created => [
                        'house_inspections' => $item->house_inspections,
                        'service_messages' => $item->service_messages,
                        'page_view' => $item->page_view,
                        'unique_visitor' => $item->unique_visitor
                    ]];
                })
                ->toArray();
            for ($i = 7; $i >= 1; $i--) {
                $subDate = now()->subDays($i)->format('Y-m-d');
                $statisticsData['house_inspections']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['house_inspections'] ?? 0;
                $statisticsData['service_messages']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['service_messages'] ?? 0;
                $statisticsData['page_view']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['page_view'] ?? 0;
                $statisticsData['unique_visitor']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['unique_visitor'] ?? 0;
            }

            // 今日数据：today
            $todayStatistic = $statistic->todayStatistic();
            $statisticsData['house_inspections']['today'] = $todayStatistic->getAttribute('house_inspections');
            $statisticsData['service_messages']['today'] = $todayStatistic->getAttribute('service_messages');
            $statisticsData['page_view']['today'] = $todayStatistic->getAttribute('page_view');
            $statisticsData['unique_visitor']['today'] = $todayStatistic->getAttribute('unique_visitor');

            return $statisticsData;
        });
        return $this->response->array($statisticsData);
    }

}
