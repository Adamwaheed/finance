<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('serial_number', 500)->nullable();
            $table->string('details', 500)->nullable();
            $table->double('total');
            $table->morphs('invoiceable');
            $table->enum('type',['credit','normal'])->default('normal');
            $table->enum('status',['outstanding','paid','cancelled','hold'])->default('outstanding');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
