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
use Atolon\Finance\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends FinanceBaseController
{

    public function index(Request $request)
    {

        $where = $request->only(['profile_id', 'status']);

        $q = Invoice::where($where)->with('profile');

        if ($request->serial_number) {
            $q->where('serial_number', 'like', '%' . $request->serial_number . '%');
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

        return $this->sendResponse($data, 'Lists Invoice successfully');
    }

    public function show($id)
    {
        $invoice = Invoice::with('profile')->find($id);

        if (!$invoice)
            return $this->sendError('not found');

        return $this->sendResponse($invoice, 'Found it successfully');
    }

    public function destroy($id)
    {
        $model = Invoice::find($id);
        if($model){
            return Finance::CancelInvoice($model);
        }
        return $this->sendError('invoice not found');

    }
}