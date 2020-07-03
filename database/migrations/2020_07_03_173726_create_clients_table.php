<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->text('address')->nullable();
            $table->string('mobile', 20)->nullable()->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->string('company', 100)->nullable();
            $table->string('type', 20)->nullable();

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
        Schema::dropIfExists('clients');
    }
}
