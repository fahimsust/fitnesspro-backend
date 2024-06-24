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
        Schema::create('discount_rule_condition_accounttypes', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucoac_rule_id');
            $table->integer('accounttype_id')->index('dirucoac_accounttype_id');
            $table->unique(['condition_id', 'accounttype_id'], 'dirucoac_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_accounttypes');
    }
};
