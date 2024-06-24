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
        Schema::create('accounts_transactions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('transid', 35);
            $table->string('ccnum', 4);
            $table->tinyInteger('ccexpmonth');
            $table->year('ccexpyear');
            $table->integer('account_id')->index('atrans_account_id');
            $table->string('zipcode', 15);
            $table->decimal('amount');
            $table->tinyInteger('status');
            $table->string('description');
            $table->decimal('orig_amount');
            $table->decimal('disc_amount');
            $table->string('disc_code', 55);
            $table->dateTime('created');
            $table->integer('membership_id');
            $table->integer('payment_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_transactions');
    }
};
