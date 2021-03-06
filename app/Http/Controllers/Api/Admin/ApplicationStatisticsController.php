<?php

namespace App\Http\Controllers\Api\Admin;

use App\Statistic;
use App\Http\Controllers\Controller;
use DB;

class ApplicationStatisticsController extends Controller
{

    /**
     * Cache repository instance
     *
     * @var object
     */
    protected $cache;

    public function __construct()
    {
        $cacheRepo = cache()->store('database');
        $this->cache = $cacheRepo;
    }

    /**
     * 获取全部应用统计数据
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAllStatistics(Statistic $statistic) {

        $cache = $this->cache;

        // 缓存相关常量
        define('CACHE_KEY', 'app_all_statistics'); // 缓存的key
        define('CACHE_EXPIRED', 60); // 缓存过期时间 min

        $statisticsData = $cache->remember(CACHE_KEY, CACHE_EXPIRED, function () use ($statistic) {

            $statisticDataItemVal = [
                'total' => 0,
                'last_7_days' => [],
                'today' => 0
            ];
            // 要缓存的统计数据的结构
            $statisticsData = [
                'messages' => $statisticDataItemVal,
                'house_inspections' => $statisticDataItemVal,
                'page_view' => $statisticDataItemVal,
                'unique_visitor' => $statisticDataItemVal,
            ];

            // 查询出数据总计数： total
            $totalCountSelectSQL = implode([
                'sum(house_inspections) as hi_total',
                'sum(messages) as mes_total',
                'sum(page_view) as pv_total',
                'sum(unique_visitor) as uv_total'
            ], ',');
            $totalCount = $statistic
                ->selectRaw($totalCountSelectSQL)
                ->first();
            $statisticsData['messages']['total'] = (int) $totalCount->mes_total;
            $statisticsData['house_inspections']['total'] = (int) $totalCount->hi_total;
            $statisticsData['page_view']['total'] = (int) $totalCount->pv_total;
            $statisticsData['unique_visitor']['total'] = (int) $totalCount->uv_total;

            // 查询最近7日数据计数：last 7 days
            $last7DaysCount = $statistic
                ->select(['house_inspections', 'messages', 'page_view', 'unique_visitor', 'date_created'])
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
                $statisticsData['messages']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['messages'] ?? 0;
                $statisticsData['page_view']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['page_view'] ?? 0;
                $statisticsData['unique_visitor']['last_7_days'][$subDate] = $last7DaysCount[$subDate]['unique_visitor'] ?? 0;
            }

            // 今日数据：today
            $todayStatistic = $statistic->todayStatistic();
            $statisticsData['house_inspections']['today'] = $todayStatistic->getAttribute('house_inspections');
            $statisticsData['messages']['today'] = $todayStatistic->getAttribute('messages');
            $statisticsData['page_view']['today'] = $todayStatistic->getAttribute('page_view');
            $statisticsData['unique_visitor']['today'] = $todayStatistic->getAttribute('unique_visitor');

            return $statisticsData;
        });

        return $this->response->array($statisticsData);
    }

    /**
     * 获取最近30天的统计数据
     *
     * @param Statistic $statistic
     * @throws \Exception
     * @return mixed
     */
    public function getPast30DaysStatistics(Statistic $statistic)
    {
        $cache = $this->cache;

        // 定义缓存相关常量
        define('CACHE_KEY', 'app_past_30_days_statistics');
        define('CACHE_EXPIRED', 60);

        $statisticsData = $cache->remember(CACHE_KEY, CACHE_EXPIRED, function () use ($statistic) {

            // 查询
            $last30DaysCount = $statistic
                ->select([
                    'house_inspections',
                    'messages',
                    'page_view',
                    'unique_visitor',
                    'date_created'
                ])
                ->where('date_created', '>=', now()->subDays(30)->format('Y-m-d'))
                ->where('date_created', '<=', now()->format('Y-m-d'))
                ->get()
                ->mapWithKeys(function ($item) {
                    $k = $item->date_created;
                    unset($item->date_created);
                    return [
                      $k => $item
                    ];
                })
                ->toArray();

            // Format
            $statisticsData = [];
            for ($i = 30; $i >= 1; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $statisticsData['house_inspections'][$date] = $last30DaysCount[$date]['house_inspections'] ?? 0;
                $statisticsData['messages'][$date] = $last30DaysCount[$date]['messages'] ?? 0;
                $statisticsData['page_view'][$date] = $last30DaysCount[$date]['page_view'] ?? 0;
                $statisticsData['unique_visitor'][$date] = $last30DaysCount[$date]['unique_visitor'] ?? 0;
            }

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
    public function getPast12MonthsStatistics(Statistic $statistic)
    {
        $cache = $this->cache;

        // 缓存相关常量
        define('CACHE_KEY', 'app_past_12_month_statistics'); // 缓存的key
        define('CACHE_EXPIRED', 60); // 缓存过期时间 min

        $statisticsData = $cache->remember(CACHE_KEY, CACHE_EXPIRED, function () use ($statistic) {

            $selectSQL = implode([
                'sum(house_inspections) as house_inspections',
                'sum(messages) as messages',
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
                $monthlyStatisticResData['house_inspections'][$month] = $monthlyStatistic[$month]['house_inspections'] ?? 0;
                $monthlyStatisticResData['messages'][$month] = $monthlyStatistic[$month]['messages'] ?? 0;
                $monthlyStatisticResData['page_view'][$month] = $monthlyStatistic[$month]['page_views'] ?? 0;
                $monthlyStatisticResData['unique_visitor'][$month] = $monthlyStatistic[$month]['unique_visitors'] ?? 0;
            }

            return $monthlyStatisticResData;
        });

        return $this->response->array($statisticsData);
    }
}
