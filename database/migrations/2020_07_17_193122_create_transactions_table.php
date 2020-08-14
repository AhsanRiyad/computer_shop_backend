<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            // $table->increments('id');
            $table->id();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');

            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->boolean('is_debit')->nullable();
            $table->boolean('is_cash')->default(true)->nullable();
            $table->boolean('is_advance')->default(false)->nullable();
            $table->double('tk' , 8 , 2)->nullable();
            $table->date('date')->nullable();

            $table->string('bank')->nullable();
            $table->string('status')->nullable();
            $table->string('branch')->nullable();
            $table->string('reference')->nullable();
            $table->date('check_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
