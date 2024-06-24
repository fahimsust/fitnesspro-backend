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
        Schema::create('saved_order', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('unique_id', 20)->index('saor_unique_id');
            $table->integer('account_id')->index('saor_account_id');
            $table->integer('saved_cart_id')->index('saor_saved_cart_id');
            $table->dateTime('created');
            $table->integer('site_id');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_order');
    }
};
