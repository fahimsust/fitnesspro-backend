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
        Schema::create('distributors_endicia', function (Blueprint $table) {
            $table->integer('distributor_id')->primary();
            $table->string('requester_id', 55);
            $table->string('account_id', 55);
            $table->string('pass_phrase', 100);
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
            $table->string('package_type', 30)->default('Parcel');
            $table->decimal('default_weight', 5, 1);
            $table->tinyInteger('test');
            $table->decimal('discount')->default(0.00);
            $table->boolean('label_creation');
            $table->integer('default_label_size');
            $table->boolean('default_label_rotate');
            $table->integer('destconfirm_label_size');
            $table->boolean('destconfirm_label_rotate');
            $table->integer('certified_label_size');
            $table->boolean('certified_label_rotate');
            $table->integer('international_label_size');
            $table->boolean('international_label_rotate');
            $table->boolean('rate_type')->comment('0=account, 1=list');
            $table->boolean('display_postage')->default(0);
            $table->boolean('display_postdate');
            $table->boolean('delivery_confirmation');
            $table->boolean('signature_confirmation');
            $table->boolean('certified_mail');
            $table->boolean('restricted_delivery');
            $table->boolean('return_receipt');
            $table->boolean('electronic_return_receipt');
            $table->boolean('hold_for_pickup');
            $table->boolean('open_and_distribute');
            $table->boolean('cod');
            $table->boolean('insured_mail');
            $table->boolean('adult_signature');
            $table->boolean('registered_mail');
            $table->boolean('am_delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_endicia');
    }
};
