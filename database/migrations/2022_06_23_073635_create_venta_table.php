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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string("sale_invoice_number",20);
            $table->date("sale_invoice_date");
            $table->string("sale_invoice_client_type",25);
            $table->double("total", 12, 2);
            $table->enum("estado", ['en_proceso', 'pagado'])->default("en_proceso");

            // Nuevas columnas
            $table->string('voucher_pago')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('users');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
