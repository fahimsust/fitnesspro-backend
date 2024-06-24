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
        Schema::create('distributors_genericshipping', function (Blueprint $table) {
            $table->integer('distributor_id')->primary();
            $table->string('company', 55);
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->integer('state_id');
            $table->string('postal_code', 55);
            $table->string('contact_name');
            $table->integer('country_id');
            $table->string('phone', 15);
            $table->string('fax', 15);
            $table->string('email', 65);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_genericshipping');
    }
};
