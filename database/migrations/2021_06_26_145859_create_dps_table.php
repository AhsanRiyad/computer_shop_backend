<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();

            $table->bigInteger('nominee_id')->unsigned()->nullable();
            $table->foreign('nominee_id')->references('id')->on('nominee');

            $table->bigInteger('collector_id')->unsigned()->nullable();
            $table->foreign('collector_id')->references('id')->on('employees');

            $table->integer('timeline')->nullable();
            $table->integer('installment')->nullable();
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
        Schema::dropIfExists('dps');
    }
}
