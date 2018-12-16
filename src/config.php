<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 02/12/2018
 * Time: 10:43 AM
 */


return [
    'profile_model' => \App\User::class,
    'user_model' => \App\User::class,


    'characters' => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',
    /*
     * Promo code prefix.
     * This will be starting string of every promocode
     * You can set it to false or string
     *
     * Ex: foo
     * Output: foo-1234-1234
     */
    'prefix' => false,
    /*
     * Promo code suffix.
     * This will be ending string of every promocode
     * You can set it to false or string
     *
     * Ex: bar
     * Output: 1234-1234-bar
     */
    'suffix' => false,
    /*
     * Promo code mask.
     * Only asterisk will be replaced, so you can add
     * or remove as many asterisk as you with
     *
     * Ex: ***-**-***
     */
    'mask' => '****-****',
    /*
     * Promo code prefix and suffix separator.
     * Can be set any thing you wish
     */
    'separator' => '-',
    /**
     * User model
     */

    /**
     * 1 = monday
     * 2 = sunday , its default in this package
     */

    'week_starts_at'=>2,



    'route_middleware'=>'',






];