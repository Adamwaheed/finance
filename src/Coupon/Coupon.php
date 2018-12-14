<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 2:20 PM
 */

namespace Atolon\Finance\Coupon;

use Atolon\Finance\Exceptions\AlreadyUsedException;
use Atolon\Finance\Exceptions\InvalidCouponcodeException;
use Atolon\Finance\Exceptions\UnauthenticatedException;
use \Atolon\Finance\Models\Coupon as Model;
use Carbon\Carbon;

class Coupon
{
    /**
     * Generated codes will be saved here
     * to be validated later.
     *
     * @var array
     */
    private $codes = [];
    /**
     * Length of code will be calculated from asterisks you have
     * set as mask in your config file.
     *
     * @var int
     */
    private $length;

    /**
     * Promocodes constructor.
     */
    public function __construct()
    {
        $this->codes = Model::pluck('code')->toArray();
        $this->length = substr_count(config('finance.mask'), '*');
    }

    public function output($amount = 1)
    {
        $collection = [];
        for ($i = 1; $i <= $amount; $i++) {
            $random = $this->generate();
            while (!$this->validate($collection, $random)) {
                $random = $this->generate();
            }
            array_push($collection, $random);
        }

        return $collection;
    }

    /**
     * Save promocodes into database
     * Successful insert returns generated promocodes
     * Fail will return empty collection.
     *
     * @param int $amount
     * @param null $reward
     * @param array $data
     * @param int|null $expires_in
     * @param bool $is_disposable
     *
     * @return \Illuminate\Support\Collection
     */
    public function create($amount = 1, $reward = null, $expires_in = null, $percentage = false)
    {
        $records = [];
        foreach ($this->output($amount) as $code) {
            $records[] = [
                'code' => $code,
                'amount' => $reward,
                'expires_at' => $expires_in ? Carbon::now()->addDays($expires_in) : null,
                'status' => 1,
                'percentage' => $percentage,
            ];
        }
        if (Model::insert($records)) {
            return collect($records)->map(function ($record) {
                return $record;
            });
        }
        return collect([]);
    }

    /**
     * Save one-time use promocodes into database
     * Successful insert returns generated promocodes
     * Fail will return empty collection.
     *
     * @param int $amount
     * @param null $reward
     * @param array $data
     * @param int|null $expires_in
     *
     * @return \Illuminate\Support\Collection
     */
    public function createDisposable($amount = 1, $reward = null, $expires_in = null)
    {
        return $this->create($amount, $reward, $expires_in, true);
    }

    /**
     * Check promocode in database if it is valid.
     *
     * @param string $code
     *
     * @return bool|Promocode
     * @throws InvalidPromocodeException
     */
    public function check($code)
    {
        $coupon = Model::byCode($code)->first();
        if ($coupon === null) {
            throw new InvalidCouponcodeException();
        }
        if ($coupon->isExpired() || $coupon->isUsed()) {
            return false;
        }
        return $coupon;
    }

    /**
     * Apply promocode to user that it's used from now.
     *
     * @param string $code
     *
     * @return bool|Promocode
     * @throws AlreadyUsedException
     * @throws UnauthenticatedException
     */
    public function apply($code, $user_id,$receipt_id)
    {
        try {
            if ($coupon = $this->check($code)) {
                if ($this->isSecondUsageAttempt($coupon)) {
                    throw new AlreadyUsedException();
                }

                $coupon->user_id = $user_id;
                $coupon->status = 0;
                $coupon->receipt_id = $receipt_id;

                $coupon->save();
                return $coupon->load('user');
            }
        } catch (InvalidCouponcodeException $exception) {
            //
        }
        return false;
    }

    /**
     * Reedem promocode to user that it's used from now.
     *
     * @param string $code
     *
     * @return bool|Promocode
     * @throws AlreadyUsedException
     * @throws UnauthenticatedException
     */
    public function redeem($code,$user_id,$receipt_id)
    {
        return $this->apply($code,$user_id,$receipt_id);
    }

    /**
     * Expire code as it won't usable anymore.
     *
     * @param string $code
     * @return bool
     * @throws InvalidPromocodeException
     */
    public function disable($code)
    {
        $coupon = Model::byCode($code)->first();
        if ($coupon === null) {
            throw new InvalidPromocodeException;
        }
        $coupon->expires_at = Carbon::now();
        $coupon->status = 0;
        return $coupon->save();
    }



    /**
     * Here will be generated single code using your parameters from config.
     *
     * @return string
     */
    private function generate()
    {
        $characters = config('finance.characters');
        $mask = config('finance.mask');
        $promocode = '';
        $random = [];
        for ($i = 1; $i <= $this->length; $i++) {
            $character = $characters[rand(0, strlen($characters) - 1)];
            $random[] = $character;
        }
        shuffle($random);
        $length = count($random);
        $promocode .= $this->getPrefix();
        for ($i = 0; $i < $length; $i++) {
            $mask = preg_replace('/\*/', $random[$i], $mask, 1);
        }
        $promocode .= $mask;
        $promocode .= $this->getSuffix();
        return $promocode;
    }

    /**
     * Generate prefix with separator for promocode.
     *
     * @return string
     */
    private function getPrefix()
    {
        return (bool)config('finance.prefix')
            ? config('finance.prefix') . config('finance.separator')
            : '';
    }

    /**
     * Generate suffix with separator for promocode.
     *
     * @return string
     */
    private function getSuffix()
    {
        return (bool)config('finance.suffix')
            ? config('finance.separator') . config('finance.suffix')
            : '';
    }

    /**
     * Your code will be validated to be unique for one request.
     *
     * @param $collection
     * @param $new
     *
     * @return bool
     */
    private function validate($collection, $new)
    {
        return !in_array($new, array_merge($collection, $this->codes));
    }

    /**
     * Check if user is trying to apply code again.
     *
     * @param Promocode $promocode
     *
     * @return bool
     */
    public function isSecondUsageAttempt(Model $coupon)
    {
        return $coupon->where('status',0)->exists();
    }
}