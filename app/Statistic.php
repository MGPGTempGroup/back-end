<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['date_created'];

    public function todayStatistic()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        return $this->firstOrCreate(['date_created' => $todayDate]);
    }
}
