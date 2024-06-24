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
        Schema::create('distributors_ups', function (Blueprint $table) {
            $table->integer('distributor_id')->primary();
            $table->string('account_no', 35);
            $table->string('company', 85);
            $table->string('phone', 15);
            $table->string('email', 65);
            $table->string('address_1', 85);
            $table->string('address_2', 85);
            $table->string('city', 35);
            $table->integer('state_id');
            $table->string('postal_code', 15);
            $table->integer('country_id');
            $table->string('license_number', 35);
            $table->string('user_id', 35);
            $table->string('password', 35);
            $table->boolean('label_creation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_ups');
    }
};
