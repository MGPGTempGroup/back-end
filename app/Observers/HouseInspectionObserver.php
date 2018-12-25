<?php

namespace App\Observers;

use App\HouseInspection;
use App\Statistic;

class HouseInspectionObserver
{
    /**
     * Statistic Model
     */
    public $statistic = null;

    public function __construct(Statistic $statistic)
    {
        $this->statistic = $statistic;
    }

    /**
     * Handle the house inspection "created" event.
     *
     * @param  \App\HouseInspection  $houseInspection
     * @return void
     */
    public function created(HouseInspection $houseInspection)
    {
        $this->statistic->todayStatistic()->increment('house_inspections');
    }

    /**
     * Handle the house inspection "updated" event.
     *
     * @param  \App\HouseInspection  $houseInspection
     * @return void
     */
    public function updated(HouseInspection $houseInspection)
    {
        //
    }

    /**
     * Handle the house inspection "deleted" event.
     *
     * @param  \App\HouseInspection  $houseInspection
     * @return void
     */
    public function deleted(HouseInspection $houseInspection)
    {
        $this->statistic->todayStatistic()->decrement('house_inspections');
    }

    /**
     * Handle the house inspection "restored" event.
     *
     * @param  \App\HouseInspection  $houseInspection
     * @return void
     */
    public function restored(HouseInspection $houseInspection)
    {
        $this->statistic->todayStatistic()->increment('house_inspections');
    }

    /**
     * Handle the house inspection "force deleted" event.
     *
     * @param  \App\HouseInspection  $houseInspection
     * @return void
     */
    public function forceDeleted(HouseInspection $houseInspection)
    {
        //
    }
}
