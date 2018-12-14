<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:32 PM
 */

namespace Atolon\Finance\Exceptions;


use Exception;

class InvoiceAlreadyExistException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Invoice already exists';
    /**
     * @var int
     */
    protected $code = 403;
}