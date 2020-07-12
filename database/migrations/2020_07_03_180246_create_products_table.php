<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // $table->id();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');
            
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            
            $table->integer('warranty')->nullable();
            $table->boolean('having_serial')->nullable();
            $table->double('cost', 8, 2)->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('alert_quantity', 8, 2)->nullable();
            $table->text('details')->nullable();
            
            $table->timestamps();
            $table->increments('id');
            $table->string('name', 100)->nullable();
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
        Schema::dropIfExists('products');
    }
}
