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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('card_code', 16);
            $table->dateTime('card_exp');
            $table->boolean('status');
            $table->decimal('amount');
            $table->integer('account_id');
            $table->string('email', 85);
            $table->integer('site_id');
            $table->unique(['card_code', 'card_exp'], 'card_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gift_cards');
    }
};
