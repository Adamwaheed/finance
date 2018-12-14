<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 10:03 AM
 */

namespace Atolon\Finance;


use Atolon\Finance\Exceptions\ReceiptNotFoundException;
use Atolon\Finance\Models\Receipt;

class ReversePayment
{
    public $receipt=null;
    public $receipt_id;

    public function __construct($receipt_id)
    {
        $this->receipt_id = $receipt_id;

        $this->receipt = Receipt::find($receipt_id);

        if(!$this->receipt){
            throw new ReceiptNotFoundException();
        }

        $this->check_invoice();

        $this->receipt->receipt_invoices()->delete();

        $this->receipt->receipt_collections()->delete();

        $this->receipt->delete();


    }

    public function check_invoice(){
        foreach ($this->receipt->invoices as $invoice){
            $invoice->status = 'outstanding';
            if($invoice->save()){
                $this->reverse_event($invoice);
            }
        }
    }

    public function reverse_event($invoice)
    {
        $invoice_class_array = explode('\\', $invoice->invoiceable_type);

        $invoiceble_model = array_pop($invoice_class_array);


        $className = "App\Modules\Finance\Events\\" . $invoiceble_model . "\\" . $invoiceble_model . "ReversePayment";

        if (class_exists($className)) {

            $event = new $className($invoice);

        }
    }
}