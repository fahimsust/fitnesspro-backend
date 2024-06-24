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
        Schema::create('affiliates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 155);
            $table->string('email', 85);
            $table->string('password', 35);
            $table->string('phone', 15);
            $table->string('address_1', 100);
            $table->string('address_2', 100);
            $table->char('city', 35);
            $table->integer('state_id');
            $table->integer('country_id');
            $table->string('postal_code', 15);
            $table->boolean('status');
            $table->integer('affiliate_level_id')->default(100);
            $table->integer('account_id')->comment('if linking account to affiliate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates');
    }
};
