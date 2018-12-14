<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 1:34 AM
 */

namespace Atolon\Finance\Models;


use Illuminate\Database\Eloquent\Model;

class ReceiptCollection extends Model
{

    protected $fillable = [
        'receipt_id',
        'reference_number',
        'reference_name',
        'type',
        'amount',
    ];

    public function receipt(){
        return $this->belongsTo(Receipt::class);
    }
}