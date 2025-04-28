<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('product_barcode', 13)->unique()->nullable();
            $table->string('product_name', 45);
            $table->string('product_description', 100)->nullable();
            $table->integer('product_stock');
            $table->decimal('product_buy_price', 10, 2);
            $table->decimal('product_sell_price', 10, 2);
            $table->string('product_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
