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
            $table->integer('brand_id')->nullable();
            $table->integer('category_id')->nullable();
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
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
            $table->integer('createdBy')->nullable();
            $table->integer('updatedBy')->nullable();
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
