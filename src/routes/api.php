<?php

Route::middleware([config('finance.route_middleware')])->prefix('finance')->group(function () {

    Route::resources([
        'invoices' => 'Atolon\Finance\Controllers\InvoiceController',
        'sequences' => 'Atolon\Finance\Controllers\SequenceController',
        'receipts' => 'Atolon\Finance\Controllers\ReceiptController',
        'coupons' => 'Atolon\Finance\Controllers\CouponController',
    ]);

    Route::get('receipt_collections/today', 'Atolon\Finance\Controllers\ReceiptCollectionController@today')->name('receipt_collections.today');
    Route::get('receipt_collections/week', 'Atolon\Finance\Controllers\ReceiptCollectionController@week')->name('receipt_collections.week');
    Route::get('receipt_collections/month', 'Atolon\Finance\Controllers\ReceiptCollectionController@month')->name('receipt_collections.month');
    Route::get('receipt_collections/year', 'Atolon\Finance\Controllers\ReceiptCollectionController@year')->name('receipt_collections.year');
    Route::get('receipt_collections/by_type', 'Atolon\Finance\Controllers\ReceiptCollectionController@by_type')->name('receipt_collections.by_type');

});