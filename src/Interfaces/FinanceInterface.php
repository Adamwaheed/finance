<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 04/12/2018
 * Time: 3:34 AM
 */

namespace Atolon\Finance\Interfaces;


interface FinanceInterface
{
    public function set_total();
    public function set_detail();
    public function set_type();
    public function set_items();
    public function calculate();

}