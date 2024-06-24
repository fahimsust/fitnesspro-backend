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
        Schema::create('accounts_loyaltypoints', function (Blueprint $table) {
            $table->integer('account_id')->index('aloyp_account_id');
            $table->integer('loyaltypoints_level_id');
            $table->integer('points_available');
            $table->unique(['account_id', 'loyaltypoints_level_id'], 'aloyp_account_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_loyaltypoints');
    }
};
