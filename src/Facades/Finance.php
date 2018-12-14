<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 09/12/2018
 * Time: 11:02 AM
 */

namespace Atolon\Finance\Facades;


use Illuminate\Support\Facades\Facade;

class Finance extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'finance';
    }

}