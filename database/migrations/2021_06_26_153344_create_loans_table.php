<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            //
            $table->id();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();

            $table->bigInteger('grantor')->unsigned()->nullable();
            $table->foreign('grantor')->references('id')->on('grantors');

            $table->bigInteger('collector_id')->unsigned()->nullable();
            $table->foreign('collector_id')->references('id')->on('employees');

            $table->integer('timeline')->nullable();
            $table->integer('amount')->nullable();
            $table->double('installment')->nullable();
            $table->date('start_date')->nullable();
            $table->double('interest_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
