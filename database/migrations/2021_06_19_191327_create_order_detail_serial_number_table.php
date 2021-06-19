<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailSerialNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_detail_serial_number', function (Blueprint $table) {
            //
            $table->bigInteger('order_detail_id')->unsigned()->nullable();
            $table->foreign('order_detail_id')->references('id')->on('order_detail');
            
            $table->bigInteger('serial_id')->unsigned()->nullable();
            $table->foreign('serial_id')->references('id')->on('serial_numbers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_detail_serial_number', function (Blueprint $table) {
            //
            Schema::dropIfExists('order_detail_serial_number');
        });
    }
}
