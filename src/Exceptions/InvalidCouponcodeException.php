<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:33 PM
 */

namespace Atolon\Finance\Exceptions;

use Exception;

class InvalidCouponcodeException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid promotion code was passed.';
    /**
     * @var int
     */
    protected $code = 404;

}