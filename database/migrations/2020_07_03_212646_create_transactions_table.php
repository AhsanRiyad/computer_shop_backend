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
            $table->integer('client_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->double('tk', 8, 2)->nullable();
            $table->boolean('is_debit')->nullable();
            $table->boolean('is_cash')->nullable();
            $table->boolean('is_advance')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('reference')->nullable();
            $table->date('check_date')->nullable();
            $table->date('date')->nullable();
            

            $table->timestamps();
            $table->increments('id');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
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
