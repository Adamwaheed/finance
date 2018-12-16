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
use Atolon\Finance\Models\Receipt;
use Atolon\Finance\Requests\Pay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mockery\Exception;

class ReceiptController extends FinanceBaseController
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {

        $where = $request->only(['profile_id', 'status']);

        $q = Receipt::where($where)->with('profile');

        if ($request->receipt_number) {
            $q->where('receipt_number', 'like', '%' . $request->receipt_number . '%');
        }


        if ($request->from_date && $request->to_date) {
            $from_date = Carbon::parse($request->from_date);
            $to_date = Carbon::parse($request->to_date);
            $q->whereBetween('created_at',[$from_date,$to_date]);
        }

        $data = $q->paginate();

        if (!$data) {
            return $this->sendError('not found');
        }

        return $this->sendResponse($data, 'Lists receipt successfully');


    }

    public function show($id)
    {
        $receipt = Receipt::with('profile')->find($id);

        if (!$receipt)
            return $this->sendError('not found');

        return $this->sendResponse($receipt, 'Found it successfully');
    }

//    payment route
    public function store(Pay $request)
    {
        try {
            $receipt = Finance::pay($request->invoice_ids, $request->user_id, $request->receipt_collections, $request->remarks);
            return $this->sendResponse($receipt, 'receipt created successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {

            $response = Finance::reverse_payment($id);

            return $this->sendResponse($response, 'receipt destroy successfully');

        } catch (\Exception $e) {

            return $this->sendError($e->getMessage());

        }
    }
}