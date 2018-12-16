<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 11:03 AM
 */

namespace Atolon\Finance\Utils;


use Carbon\Carbon;

class MakeDate
{
    public $date;
    public $date_array = [];


    public function __construct()
    {

        Carbon::setWeekStartsAt(config('finance.week_starts_at'));
    }


    public function today($date = null)
    {
        $this->date = $date ? Carbon::parse($date) : Carbon::today();
        $start = clone $this->date->setTime('00', '00', '00');
        $end = clone $this->date->setTime('23', '59', '59');
        return [
            $start, $end
        ];
    }

    public function week($date=null)
    {
        $this->date = $date ? Carbon::parse($date) : Carbon::today();
        $start = clone $this->date->startOfWeek()->setTime('00', '00', '00');
        $end = clone $this->date->endOfWeek()->setTime('23', '59', '59');

        return [
            $start, $end
        ];
    }

    public function month($date=null)
    {

        $this->date = $date ? Carbon::parse($date) : Carbon::today();
        $start = clone $this->date->startOfMonth()->setTime('00', '00', '00');
        $end = clone $this->date->endOfMonth()->setTime('23', '59', '59');

        return [
            $start, $end
        ];

    }

    public function year($date)
    {
        $this->date = $date ? Carbon::parse($date) : Carbon::today();
        $start = clone $this->date->startOfYear()->setTime('00', '00', '00');
        $end = clone $this->date->endOfYear()->setTime('23', '59', '59');

        return [
            $start, $end
        ];
    }

}