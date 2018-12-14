<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 10:47 AM
 */

namespace Atolon\Finance\Controllers;


use App\Http\Controllers\Controller;
use Atolon\Finance\Facades\Finance;
use Atolon\Finance\Models\Coupon;
use Atolon\Finance\Requests\CreateCoupon;
use Illuminate\Http\Request;

class CouponController extends FinanceBaseController
{


    public function index(Request $request)
    {

        $where = $request->only(['user_id', 'status']);

        $q = Coupon::where($where);

        if ($request->code) {
            $q->where('code', 'like', '%' . $request->code . '%');
        }

        $data = $q->paginate();

        if (!$data) {
            return $this->sendError('not found');
        }

        return $this->sendResponse($data, 'Lists Coupon successfully');
    }

    public function store(CreateCoupon $request)
    {
        $per = $request->percentage ? true : false;
        return Finance::CreateCoupon($request->amount, $request->reward, $request->expires_in, $per);
    }

    public function destroy($id){
        $coupon = Coupon::find($id);

        if (!$coupon)
            return  $this->sendError('not found Sequence');

        $coupon->delete();

        return $this->sendResponse([], 'destroyed successfully');
    }
}