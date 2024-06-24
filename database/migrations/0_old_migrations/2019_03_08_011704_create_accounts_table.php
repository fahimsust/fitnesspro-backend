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
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('account_email', 85);
            $table->string('account_user', 55);
            $table->string('account_pass', 35);
            $table->string('account_phone', 15);
            $table->dateTime('account_created');
            $table->dateTime('account_lastlogin');
            $table->tinyInteger('account_status_id')->index('account_status_id');
            $table->integer('account_type_id')->default(1);
            $table->integer('default_billing_id');
            $table->integer('default_shipping_id');
            $table->integer('affiliate_id');
            $table->integer('cim_profile_id');
            $table->string('first_name', 55);
            $table->string('last_name', 55);
            $table->text('admin_notes');
            $table->integer('photo_id');
            $table->integer('site_id');
            $table->integer('loyaltypoints_id');
            $table->boolean('profile_public')->default(1);
            $table->tinyInteger('send_verify_email')->comment('0 = allow, 1=disallow');
            $table->date('last_verify_attempt_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
