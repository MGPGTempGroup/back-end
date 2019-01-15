<?php

namespace App\Observers;

use App\CustomerLeaveMessage;
use App\Statistic;

class CustomerLeaveMessageObserver
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
     * Handle the customer leave message "created" event.
     *
     * @param  \App\CustomerLeaveMessage  $customerLeaveMessage
     * @return void
     */
    public function created(CustomerLeaveMessage $customerLeaveMessage)
    {
        $this->statistic->todayStatistic()->increment('messages');
    }

    /**
     * Handle the customer leave message "updated" event.
     *
     * @param  \App\CustomerLeaveMessage  $customerLeaveMessage
     * @return void
     */
    public function updated(CustomerLeaveMessage $customerLeaveMessage)
    {
        //
    }

    /**
     * Handle the customer leave message "deleted" event.
     *
     * @param  \App\CustomerLeaveMessage  $customerLeaveMessage
     * @return void
     */
    public function deleted(CustomerLeaveMessage $customerLeaveMessage)
    {
        $this->statistic->todayStatistic()->decrement('messages');
    }

    /**
     * Handle the customer leave message "restored" event.
     *
     * @param  \App\CustomerLeaveMessage  $customerLeaveMessage
     * @return void
     */
    public function restored(CustomerLeaveMessage $customerLeaveMessage)
    {
        $this->statistic->todayStatistic()->increment('messages');
    }

    /**
     * Handle the customer leave message "force deleted" event.
     *
     * @param  \App\CustomerLeaveMessage  $customerLeaveMessage
     * @return void
     */
    public function forceDeleted(CustomerLeaveMessage $customerLeaveMessage)
    {
        //
    }
}
