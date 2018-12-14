<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('data_type', 12);
            $table->string('current_number', 200);
            $table->string('prefix', 10);
            $table->string('post_fix', 10);
            $table->string('template', 100);
            $table->string('date', 10);
            $table->string('initial_number', 200);
            $table->string('reset_by', 200);
            $table->string('type', 200);
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
        Schema::dropIfExists('sequences');
    }
}
