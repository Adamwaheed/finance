<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 1:25 AM
 */

namespace Atolon\Finance\Models;


use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id',
        'details',
        'rate',
        'UOM',
        'qty',
        'type',
        'charge_type',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }


}