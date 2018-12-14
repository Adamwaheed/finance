<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:32 PM
 */

namespace Atolon\Finance\Exceptions;


use Exception;

class ReceiptNotFoundException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Receipt Not Found Exception';
    /**
     * @var int
     */
    protected $code = 403;
}