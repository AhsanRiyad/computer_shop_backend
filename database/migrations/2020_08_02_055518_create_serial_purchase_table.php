<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial_purchase', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');

            $table->string('number')->nullable()->unique();


            $table->bigInteger('order_detail_id')->unsigned()->nullable();
            $table->foreign('order_detail_id')->references('id')->on('order_details');

            $table->string('status')->nullable()->unique();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serial_purchase');
    }
}
