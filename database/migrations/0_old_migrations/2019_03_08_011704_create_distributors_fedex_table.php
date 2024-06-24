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
        Schema::create('distributors_fedex', function (Blueprint $table) {
            $table->integer('distributor_id')->primary();
            $table->string('accountno', 55);
            $table->string('meterno', 55);
            $table->string('keyword', 35);
            $table->string('pass', 35);
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
            $table->string('package_type', 30);
            $table->decimal('default_weight', 5, 1);
            $table->tinyInteger('test');
            $table->decimal('discount')->default(0.00);
            $table->boolean('label_creation');
            $table->boolean('rate_type')->comment('0=account, 1=list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_fedex');
    }
};
