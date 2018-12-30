<?php

namespace App\Http\Controllers\Api\Admin;

use App\Statistic;
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
            $totalCountSelectSQL = implode([
                'sum(house_inspections) as hi_total',
                'sum(service_messages) as ss_total',
                'sum(page_view) as pv_total',
                'sum(unique_visitor) as uv_total'
            ], ',');
            $totalCount = $statistic
                ->selectRaw($totalCountSelectSQL)
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
                    $k = $item->date_created;
                    unset($item->date_created);
                    return [$k => (array) $item];
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

    /**
     * 获取最近12个月的统计数据
     *
     * @params Statistic $statistics
     * @throws \Exception
     * @return mixed
     */
    public function getMonthlyStatistics(Statistic $statistic)
    {
        $cache = cache()->store('database');
        define('CACHE_EXPIRED', 60); // min

        $statisticsData = $cache->remember('app_monthly_statistics', CACHE_EXPIRED, function () use ($statistic) {

            $selectSQL = implode([
                'sum(house_inspections) as house_inspections',
                'sum(service_messages) as service_messages',
                'sum(page_view) as page_views',
                'sum(unique_visitor) as unique_visitors',
                'DATE_FORMAT(date_created, \'%Y-%m\') as month_date_created'
            ], ', ');
            $subMonth = now()->subMonthsNoOverflow(11)->format('Y-m');
            $monthlyStatistic = DB::table('statistics')
                ->selectRaw($selectSQL)
                ->whereRaw('DATE_FORMAT(date_created, \'%Y-%m\') >= ?', [$subMonth])
                ->groupBy('month_date_created')
                ->get()
                ->mapWithKeys(function ($item) {
                    $date = $item->month_date_created;
                    unset($item->month_date_created);
                    $value = array_map('intval', (array) $item);
                    return [$date => (array) $value];
                })
                ->toArray();

            $monthlyStatisticResData = [];
            for ($i = 11; $i >= 0; $i--) {
                $month = now()->subMonthsNoOverflow($i)->format('Y-m');
                echo $month . PHP_EOL;
                $monthlyStatisticResData[$month]['house_inspections'] = $monthlyStatistic[$month]['house_inspections'] ?? 0;
                $monthlyStatisticResData[$month]['service_messages'] = $monthlyStatistic[$month]['service_messages'] ?? 0;
                $monthlyStatisticResData[$month]['page_views'] = $monthlyStatistic[$month]['page_views'] ?? 0;
                $monthlyStatisticResData[$month]['unique_visitors'] = $monthlyStatistic[$month]['unique_visitors'] ?? 0;
            }

            return $monthlyStatisticResData;
        });

        return $this->response->array($statisticsData);
    }
}
