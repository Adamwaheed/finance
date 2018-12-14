<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 1:31 AM
 */

namespace Atolon\Finance\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'profile_id',
        'user_id',
        'receipt_number',
        'remarks',
        'status',
        'total',
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_receipts', 'receipt_id','invoice_id' );
    }

    public function profile(){
        return  $this->belongsTo(config('finance.profile_model'), 'profile_id','id');
    }

    public function user(){
        return  $this->belongsTo(config('finance.user_model'), 'user_id','id');
    }

    public function receipt_invoices()
    {
        return $this->hasMany(InvoiceReceipt::class, 'receipt_id','id' );
    }

    public function receipt_collections()
    {
        return $this->hasMany(ReceiptCollection::class, 'receipt_id','id' );
    }
}