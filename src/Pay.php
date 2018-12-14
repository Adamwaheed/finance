<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 09/12/2018
 * Time: 10:49 PM
 */

namespace Atolon\Finance;


use Atolon\Finance\Exceptions\InvoiceNotFoundException;
use Atolon\Finance\Jobs\GiveSequence;
use Atolon\Finance\Models\Invoice;
use Atolon\Finance\Models\InvoiceReceipt;
use Atolon\Finance\Models\Receipt;
use Atolon\Finance\Models\ReceiptCollection;

class Pay
{
    public $profile_id;
    public $user_id;
    public $total;
    public $status;
    public $invoice_ids;
    public $receipt_collections = [];
    public $invoices;

    public function __construct($invoice_ids, $user_id, $receipt_collections, $remarks)
    {
        $this->invoice_ids = $invoice_ids;
        $this->user_id = $user_id;
        $this->status = 1;
        $this->receipt_collections = $receipt_collections;
        $this->remarks = $remarks;

        $this->get_invoices();

        $this->set_profile_id();

        $this->set_total();


    }

    public function get_invoices()
    {
        $this->invoices = Invoice::whereIn('id', $this->invoice_ids)->outstanding()->get();
        if (!count($this->invoices)) {
            throw new InvoiceNotFoundException();
        }
    }

    /* this function will get profile id
     * */
    public function set_profile_id()
    {
        $invoice = Invoice::whereIn('id', $this->invoice_ids)->first();
        if ($invoice) {
            $this->profile_id = $invoice->profile_id;
        }
    }

    public function set_total()
    {
        $receipt_collections = collect($this->receipt_collections);
        $this->total = $receipt_collections->sum('amount');
    }

    public function create_receipt()
    {
        $receipt = new Receipt();
        $receipt->profile_id = $this->profile_id;
        $receipt->user_id = $this->user_id;
        $receipt->receipt_number = '-';
        $receipt->remarks = $this->remarks;
        $receipt->total = $this->total;
        $receipt->status = $this->status;

        if ($receipt->save()) {

            GiveSequence::dispatch($receipt, 'receipt_number', 'receipt_number');

            $this->create_receipt_collection($receipt);

            $this->update_invoice($receipt);

            return $receipt;
        }
    }


    public function create_receipt_collection($receipt)
    {
        foreach ($this->receipt_collections as $item) {
            $receipt_collection = new ReceiptCollection();
            $receipt_collection->receipt_id = $receipt->id;
            $receipt_collection->reference_number = $item['reference_number'];
            $receipt_collection->reference_name = $item['reference_name'];
            $receipt_collection->type = $item['type'];
            $receipt_collection->amount = round($item['amount'], 2);
            $receipt_collection->save();
        }
    }

    public function update_invoice($receipt)
    {


        foreach ($this->invoices as $invoice) {
            $invoice->status = 'paid';
            if ($invoice->save()) {
                $invoice_receipt = new InvoiceReceipt();
                $invoice_receipt->invoice_id = $invoice->id;
                $invoice_receipt->receipt_id = $receipt->id;
                $invoice_receipt->save();
                $this->call_paid_event($invoice);
            }
        }
    }


    public function call_paid_event($invoice)
    {
        $invoice_class_array = explode('\\', $invoice->invoiceable_type);

        $invoiceble_model = array_pop($invoice_class_array);


        $className = "App\Modules\Finance\Events\\" . $invoiceble_model . "\\" . $invoiceble_model . "InvoicePaid";

        if (class_exists($className)) {

            $event = new $className($invoice);

        }
    }

}