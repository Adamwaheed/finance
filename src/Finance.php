<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 09/12/2018
 * Time: 11:04 AM
 */

namespace Atolon\Finance;

use Atolon\Finance\Coupon\Coupon;
use Atolon\Finance\Exceptions\InvoiceAlreadyExistException;
use Atolon\Finance\Interfaces\FinanceInterface;
use Atolon\Finance\Jobs\GiveSequence;
use Atolon\Finance\Models\Invoice;
use Atolon\Finance\Models\Receipt;


class Finance
{
    public $result;
    public $invoicebleModel;
    public $error;
    public $error_message;

    public $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function RaiseInvoice(FinanceInterface $model, $customer_id)
    {


        $this->result = $model->calculate();

        $invoice_exist = Invoice::whereInvoiceableType($this->result->invoiceable_type)->whereInvoiceableId($this->result->invoiceable_id)->first();

        if ($invoice_exist) {

            throw new InvoiceAlreadyExistException();

        }

        $invoice = new Invoice();

        $invoice->serial_number = '-';

        $invoice->details = $this->result->details;

        $invoice->total = $this->result->total;

        $invoice->type = $this->result->type;

        $invoice->status = $this->result->status;

        $invoice->invoiceable_type = $this->result->invoiceable_type;

        $invoice->invoiceable_id = $this->result->invoiceable_id;

        $invoice->profile_id = $customer_id;

        if ($invoice->save()) {

            GiveSequence::dispatch($invoice, 'serial_number', 'invoice_number');

            $invoice_class_array = explode('\\', $this->result->invoiceable_type);

            $this->invoicebleModel = array_pop($invoice_class_array);


            $className = "App\Modules\Finance\Events\\" . $this->invoicebleModel . "\\" . $this->invoicebleModel . "InvoiceCreated";

            if (class_exists($className)) {

                $event = new $className($invoice);

            }


        }

    }

    public function CancelInvoice(Invoice $invoice)
    {

        if ($invoice->delete()) {

            $invoice_class_array = explode('\\', $invoice->invoiceable_type);

            $this->invoicebleModel = array_pop($invoice_class_array);


            $className = "App\Modules\Finance\Events\\" . $this->invoicebleModel . "\\" . $this->invoicebleModel . "InvoiceCancelled";


            if (class_exists($className)) {

                $event = new $className($invoice);

            }

            return true;
        }
    }

    public function pay($invoice_ids, $user_id, $receipt_collections, $remarks)
    {
        $pay = new Pay($invoice_ids, $user_id, $receipt_collections, $remarks);

        return $pay->create_receipt();
    }

    public function reverse_payment($receipt_id)
    {
        $reverse_payment = new ReversePayment($receipt_id);
        return $reverse_payment;
    }

    public function CreateCoupon($amount = 1, $reward = null, $expires_in = null, $percentage = false)
    {
        $coupon = new Coupon();
        return $coupon->create($amount, $reward, $expires_in, $percentage);

    }

    public function DisableCoupon($code)
    {
        return $this->coupon->disable($code);
    }
}