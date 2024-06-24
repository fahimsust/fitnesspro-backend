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
        Schema::create('cim_profile_paymentprofile', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('profile_id')->index('profile_id');
            $table->integer('first_cc_number');
            $table->string('cc_number', 4);
            $table->date('cc_exp');
            $table->string('zipcode', 10);
            $table->string('authnet_payment_profile_id', 20);
            $table->boolean('is_default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cim_profile_paymentprofile');
    }
};
