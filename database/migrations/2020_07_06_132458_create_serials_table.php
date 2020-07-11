<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->timestamps();
            
            $table->increments('id');
            $table->string('number', 100)->unique();
            
            $table->string('status', 100)->nullable();
            $table->integer('product_id')->nullable();

            $table->integer('order_id_p')->nullable();
            $table->integer('order_id_s')->nullable();

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
        Schema::dropIfExists('serials');
    }
}
