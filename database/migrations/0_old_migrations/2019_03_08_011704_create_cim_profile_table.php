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
        Schema::create('cim_profile', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('authnet_profile_id', 20);
            $table->integer('gateway_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cim_profile');
    }
};
