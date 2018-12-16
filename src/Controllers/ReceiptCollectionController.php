<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 10:47 AM
 */

namespace Atolon\Finance\Controllers;


use App\Http\Controllers\Controller;
use Atolon\Finance\Models\ReceiptCollection;
use Atolon\Finance\Requests\CreateSequences;
use Atolon\Finance\Utils\MakeDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceiptCollectionController extends FinanceBaseController
{

    public function today(Request $request)
    {

        $make_date = new MakeDate();

        $data = ReceiptCollection::select(\DB::raw('sum(amount) as total , type'))
            ->groupBy('type')
            ->whereBetween('created_at',$make_date->today($request->date))
            ->get();

        if ($data) {
            return $this->sendResponse($data, 'ReceiptCollection Loaded Successfully');
        }

        return $this->sendError('Not found Sequence');
    }

    public function week(Request $request)
    {

        $make_date = new MakeDate();

        $data = ReceiptCollection::select(\DB::raw('sum(amount) as total , type'))
            ->groupBy('type')
            ->whereBetween('created_at',$make_date->week($request->date))
            ->get();

        if ($data) {
            return $this->sendResponse($data, 'ReceiptCollection Loaded Successfully');
        }

        return $this->sendError('Not found Sequence');
    }


    public function month(Request $request)
    {

        $make_date = new MakeDate();

        $data = ReceiptCollection::select(\DB::raw('sum(amount) as total , type'))
            ->groupBy('type')
            ->whereBetween('created_at',$make_date->month($request->date))
            ->get();

        if ($data) {
            return $this->sendResponse($data, 'ReceiptCollection Loaded Successfully');
        }

        return $this->sendError('Not found Sequence');
    }

    public function year(Request $request)
    {

        $make_date = new MakeDate();

        $data = ReceiptCollection::select(\DB::raw('sum(amount) as total , type'))
            ->groupBy('type')
            ->whereBetween('created_at',$make_date->year($request->date))
            ->get();

        if ($data) {
            return $this->sendResponse($data, 'ReceiptCollection Loaded Successfully');
        }

        return $this->sendError('Not found Sequence');
    }

    public function by_type(Request $request){
        $data = ReceiptCollection::whereType($request->type);

        if ($request->from_date && $request->to_date) {
            $from_date = Carbon::parse($request->from_date);
            $to_date = Carbon::parse($request->to_date);
            $data->whereBetween('created_at',[$from_date,$to_date]);
        }

        return $this->sendResponse($data->get(), 'Sequence Loaded Successfully');
    }


}