<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('provider_company_name',length: 55);
            $table->string('provider_company_rtn',16);
            $table->string('provider_company_phone',8);
            $table->string('provider_company_address',255);
            $table->string('provider_contact_name',55);
            $table->string('provider_contact_phone',8);
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
        Schema::dropIfExists('proveedors');
    }
};
