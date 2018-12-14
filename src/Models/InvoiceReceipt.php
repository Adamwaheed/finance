<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 1:33 AM
 */

namespace Atolon\Finance\Models;


use Illuminate\Database\Eloquent\Model;

class InvoiceReceipt extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'invoice_id',
        'receipt_id',
    ];

    public function invoice(){
        $this->belongsTo(Invoice::class);
    }


    public function receipt(){
        $this->belongsTo(Receipt::class);
    }
}