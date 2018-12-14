<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 11:03 AM
 */

namespace Atolon\Finance\Utils;


class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }
    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];
        if (!empty($data)) {
            $res['data'] = $data;
        }
        return $res;
    }

}