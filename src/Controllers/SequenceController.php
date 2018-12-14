<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 10:47 AM
 */

namespace Atolon\Finance\Controllers;


use App\Http\Controllers\Controller;
use Atolon\Finance\Models\Sequence;
use Atolon\Finance\Requests\CreateSequences;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SequenceController extends FinanceBaseController
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $data = Sequence::paginate();
        if ($data) {
            return $this->sendResponse($data, 'Sequence Loaded Successfully');
        }

        return $this->sendError('Not found Sequence');
    }

    public function store(CreateSequences $request)
    {
        $sequence = new Sequence($request->all());
        $sequence->date = Date('y-M-D');
        if (!$sequence->save())
            $this->sendError('Unable to save');

        return $this->sendResponse($sequence, 'Sequence created successfully');


    }


    public function show($id)
    {
        $sequence = Sequence::find($id);

        if (!$sequence)
            return $this->sendError('not found');

        return $this->sendResponse($sequence, 'Found it successfully');

    }

    public function update(CreateSequences $request, $id)
    {
        $sequence = Sequence::find($id);
        $sequence->fill($request->all());
        $sequence->date = Date('y-M-D');
        if (!$sequence->save())
            $this->sendError('Unable to save');

        return $this->sendResponse($sequence, 'Sequence Updated successfully');

    }


    public function destroy($id)
    {
        $sequence = Sequence::whereId($id)->whereNotIn('type',['receipt_number','invoice_number'])->first();

        if (!$sequence)
          return  $this->sendError('not found Sequence');

        $sequence->delete();

        return $this->sendResponse([], 'destroyed successfully');


    }
}