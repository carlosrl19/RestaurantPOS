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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name', 25);
            $table->string('system_logo');
            $table->string('system_logo_report');
            $table->string('company_name', 25)->nullable();
            $table->string('company_cai', 32)->nullable();
            $table->string('company_rtn', 14)->nullable();
            $table->string('company_phone', 8)->nullable();
            $table->string('company_email', 50)->nullable();
            $table->string('company_address', 75)->nullable();
            $table->string('company_short_address', 35)->nullable();
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
        Schema::dropIfExists('settings');
    }
};
