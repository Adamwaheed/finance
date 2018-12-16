<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 01/12/2018
 * Time: 9:30 AM
 */


//Route::get('raise', function () {
////    return \Atolon\Finance\models\Receipt::with(['invoices','user'])->get();
////    return response()->json(auth()->user());
////    $id = \Illuminate\Support\Facades\Auth::id();
////    dd($id);
//
////    $con = new \Atolon\Finance\Coupon\Coupon();
//////   return $con->create(12,50,10,true);
////   $result = $con->apply('QK5D-YPXY',1,1);
////   dd($result);
//    $model = \App\Flight::find(1);
//    $charge = new  \App\Modules\Finance\Charges\FlightCharge($model);
//    return Finance::RaiseInvoice($charge, 1);
//
//});
//
//
//Route::get('cancel', function () {
////    return \Atolon\Finance\models\Receipt::with(['invoices','user'])->get();
////    return response()->json(auth()->user());
////    $id = \Illuminate\Support\Facades\Auth::id();
////    dd($id);
//
////    $con = new \Atolon\Finance\Coupon\Coupon();
//////   return $con->create(12,50,10,true);
////   $result = $con->apply('QK5D-YPXY',1,1);
////   dd($result);
//    $model = \Atolon\Finance\Models\Invoice::find(17);
//
//    return Finance::CancelInvoice($model);
//
//});
//
//Route::get('pay', function () {
//
//    $invoice_ids = [18, 19];
//    $user_id = 1;
//    $receipt_collections = [
//        [
//            'reference_number' => '12313123',
//            'reference_name' => 'asdasdas',
//            'type' => 'cash',
//            'amount' => 4100,
//
//        ],
//        [
//            'reference_number' => '12313123',
//            'reference_name' => 'asdasdas',
//            'type' => 'card',
//            'amount' => 1002,
//
//        ],
//    ];
//
//    $remarks = 'asdasdasdasda';
//    try{
//        Finance::pay($invoice_ids, $user_id, $receipt_collections, $remarks);
//    }catch (Exception $e){
//        return $e->getMessage();
//    }
//
//
//});
//
//
//Route::get('reverse/{id}', function ($receipt_id) {
//
//
//    return Finance::reverse_payment($receipt_id);
//
//});
//
//
//Route::group([
//
//    'middleware' => 'api',
//    'prefix' => 'auth'
//
//], function ($router) {
//
//    Route::post('login', 'AuthController@login');
//    Route::post('logout', 'AuthController@logout');
//    Route::post('refresh', 'AuthController@refresh');
//    Route::post('me', 'AuthController@me');
//
//});

Route::resources([
    'invoices' => 'Atolon\Finance\Controllers\InvoiceController',
    'sequences' => 'Atolon\Finance\Controllers\SequenceController',
    'receipts' => 'Atolon\Finance\Controllers\ReceiptController',
    'coupons' => 'Atolon\Finance\Controllers\CouponController',
]);

Route::get('receipt_collections/today', 'Atolon\Finance\Controllers\ReceiptCollectionController@today');
Route::get('receipt_collections/week', 'Atolon\Finance\Controllers\ReceiptCollectionController@week');
Route::get('receipt_collections/month', 'Atolon\Finance\Controllers\ReceiptCollectionController@month');
Route::get('receipt_collections/year', 'Atolon\Finance\Controllers\ReceiptCollectionController@year');
Route::get('receipt_collections/by_type', 'Atolon\Finance\Controllers\ReceiptCollectionController@by_type');