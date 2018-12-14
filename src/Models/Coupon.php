<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:12 PM
 */

namespace Atolon\Finance\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'amount',
        'percentage',
        'user_id',
        'receipt_id',
        'expires_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(config('finance.user_model'), 'user_id', 'id');
    }

    public function receipt()
    {
        $this->belongsTo(Receipt::class);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Query builder to get expired promotion codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')->whereDate('expires_at', '<=', Carbon::now());
    }

    public function isExpired()
    {
        return $this->expires_at ? Carbon::now()->gte($this->expires_at) : false;
    }

    public function isUsed(): bool
    {
        return $this->user_id ? true : false;
    }
}