<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 11:04 AM
 */
namespace Atolon\Finance\Controllers;
use App\Http\Controllers\Controller;
use Atolon\Finance\Utils\ResponseUtil;
use Illuminate\Http\Response;

class FinanceBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return  response()->json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return  response()->json(ResponseUtil::makeError($error), $code);
    }

}