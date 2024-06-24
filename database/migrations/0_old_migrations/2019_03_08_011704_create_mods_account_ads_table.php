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
        Schema::create('mods_account_ads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('maa_account_id');
            $table->string('name');
            $table->string('link', 500);
            $table->string('img', 155);
            $table->integer('clicks');
            $table->integer('shown');
            $table->boolean('status')->default(1);
            $table->dateTime('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_account_ads');
    }
};
