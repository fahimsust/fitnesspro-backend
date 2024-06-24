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
        Schema::create('accounts_addressbook', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('account_id');
            $table->string('label', 35);
            $table->boolean('is_billing');
            $table->boolean('is_shipping');
            $table->string('company', 155);
            $table->string('first_name', 55);
            $table->string('last_name', 55);
            $table->string('address_1', 85);
            $table->string('address_2', 85);
            $table->string('city', 35);
            $table->integer('state_id');
            $table->integer('country_id');
            $table->string('postal_code', 15);
            $table->string('email', 85);
            $table->string('phone', 15);
            $table->boolean('is_residential');
            $table->boolean('status');
            $table->integer('old_billingid');
            $table->integer('old_shippingid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_addressbook');
    }
};
