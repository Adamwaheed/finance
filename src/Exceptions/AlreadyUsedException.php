<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:32 PM
 */

namespace Atolon\Finance\Exceptions;


use Exception;

class AlreadyUsedException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Promotion code is already used by current user.';
    /**
     * @var int
     */
    protected $code = 403;
}