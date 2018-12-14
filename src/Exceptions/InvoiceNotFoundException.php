<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:32 PM
 */

namespace Atolon\Finance\Exceptions;


use Exception;

class InvoiceNotFoundException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Invoice not found';
    /**
     * @var int
     */
    protected $code = 403;
}