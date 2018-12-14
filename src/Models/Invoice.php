<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 1:25 AM
 */

namespace Atolon\Finance\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{

    //status('outstanding','paid','cancelled','hold')
    //status('credit','normal') [normal]

    use SoftDeletes;

    protected $fillable = [
        'profile_id',
        'serial_number',
        'details',
        'total',
        'invoiceable_type',
        'invoiceable_id',
        'type',
        'status',
    ];

    public function  items(){
        return $this->hasMany(InvoiceItem::class,'invoice_id','id');
    }

    public function payload(){
        return  $this->morphOne(Payload::class, 'payloadable');
    }

    public function profile(){
        return  $this->belongsTo(config('finance.profile_model'), 'profile_id','id');
    }

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function ScopeOutstanding($query){
        return $query->where('status','outstanding');
    }

    public function ScopePaid($query){
        return $query->where('status','paid');
    }

    public function ScopeCancelled($query){
        return $query->where('status','paid');
    }

    public function ScopeHold($query){
        return $query->where('status','paid');
    }

    public function ScopeCredit($query){
        return $query->where('type','credit');
    }

    public function ScopeCreditOutstanding($query){
        return $query->where('type','credit')->where('status','outstanding');
    }

    public function ScopeCreditPaid($query){
        return $query->where('type','credit')->where('status','paid');
    }



}