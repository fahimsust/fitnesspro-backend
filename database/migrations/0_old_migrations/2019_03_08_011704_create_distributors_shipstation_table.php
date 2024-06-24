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
        Schema::create('distributors_shipstation', function (Blueprint $table) {
            $table->integer('distributor_id')->primary();
            $table->string('api_key', 55);
            $table->string('api_secret', 55);
            $table->string('company', 55);
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->integer('state_id');
            $table->string('postal_code', 55);
            $table->string('contact_name');
            $table->integer('country_id');
            $table->boolean('is_residential');
            $table->string('phone', 15);
            $table->string('fax', 15);
            $table->string('email', 65);
            $table->string('package_type', 30)->default('Parcel');
            $table->decimal('default_weight', 5, 1);
            $table->tinyInteger('test');
            $table->decimal('discount')->default(0.00);
            $table->boolean('label_creation');
            $table->boolean('delivery_confirmation');
            $table->boolean('insured_mail');
            $table->string('storeid', 35);
            $table->boolean('nondelivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_shipstation');
    }
};
