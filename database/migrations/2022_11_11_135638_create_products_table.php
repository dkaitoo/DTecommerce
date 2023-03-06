<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tittle');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('seller_id'); //ai bán
            $table->string('brand');
            $table->longText('description')->nullable();

            $table->bigInteger('original_price');
            $table->bigInteger('selling_price');
            $table->integer('qty');//so luong
            $table->json('attributes')->nullable();

            $table->tinyInteger('status');
            $table->tinyInteger('trending');
            $table->string('other_attribute')->nullable();
            $table->integer('average_star')->default('0')->nullable();
            $table->bigInteger('sold')->default('0')->nullable();

            // rate, đã bán dc bn

            // seller
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
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
};
