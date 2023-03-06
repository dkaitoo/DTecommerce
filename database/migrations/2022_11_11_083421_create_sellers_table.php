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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // thuộc tài khoản user nào
//            $table->unsignedBigInteger('category_id'); // bán thể loại gì
            $table->string('name'); // tên trên cccd
            $table->string('identity_card'); // số định danh trên cccd
            $table->string('store_name')->unique();
            $table->string('slug');
            $table->string('logo')->default('img/logoStore.png'); // hiển thị trên cửa hàng
            $table->string('address'); //nơi bán hàng
            $table->string('phone');
            $table->boolean('approved')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
};
