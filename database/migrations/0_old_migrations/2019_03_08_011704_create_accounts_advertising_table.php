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
        Schema::create('accounts_advertising', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('aa_account_id');
            $table->string('name');
            $table->string('link', 500);
            $table->string('img', 155);
            $table->integer('clicks');
            $table->integer('shown');
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_advertising');
    }
};
