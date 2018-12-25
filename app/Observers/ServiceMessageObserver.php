<?php

namespace App\Observers;

use App\ServiceMessage;
use App\Statistic;

class ServiceMessageObserver
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
     * Handle the service message "created" event.
     *
     * @param  \App\ServiceMessage  $serviceMessage
     * @return void
     */
    public function created(ServiceMessage $serviceMessage)
    {
        $this->statistic->todayStatistic()->increment('service_messages');
    }

    /**
     * Handle the service message "updated" event.
     *
     * @param  \App\ServiceMessage  $serviceMessage
     * @return void
     */
    public function updated(ServiceMessage $serviceMessage)
    {
        //
    }

    /**
     * Handle the service message "deleted" event.
     *
     * @param  \App\ServiceMessage  $serviceMessage
     * @return void
     */
    public function deleted(ServiceMessage $serviceMessage)
    {
        $this->statistic->todayStatistic()->decrement('service_messages');
    }

    /**
     * Handle the service message "restored" event.
     *
     * @param  \App\ServiceMessage  $serviceMessage
     * @return void
     */
    public function restored(ServiceMessage $serviceMessage)
    {
        $this->statistic->todayStatistic()->increment('service_messages');
    }

    /**
     * Handle the service message "force deleted" event.
     *
     * @param  \App\ServiceMessage  $serviceMessage
     * @return void
     */
    public function forceDeleted(ServiceMessage $serviceMessage)
    {
        //
    }
}
