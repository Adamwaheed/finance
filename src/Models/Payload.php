<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 1:34 AM
 */

namespace Atolon\Finance\Models;


use Illuminate\Database\Eloquent\Model;

class Payload extends Model
{

    public function payloadable()
    {
        return $this->morphTo();
    }

}