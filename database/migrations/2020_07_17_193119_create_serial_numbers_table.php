<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_numbers', function (Blueprint $table) {
            // $table->increments('id');
            $table->id();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');

            $table->bigInteger('order_return_id')->unsigned()->nullable();
            $table->foreign('order_return_id')->references('id')->on('order_return');

            $table->bigInteger('order_detail_id')->unsigned()->nullable();
            $table->foreign('order_detail_id')->references('id')->on('order_detail');

            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->bigInteger('warranty_detail_id')->unsigned()->nullable();
            $table->foreign('warranty_detail_id')->references('id')->on('warranty_detail');


            $table->bigInteger('warranty_exchange_detail_id')->unsigned()->nullable();
            $table->foreign('warranty_exchange_detail_id')->references('id')->on('warranty_exchange_detail');

            $table->string('status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serial_numbers');
    }
}
