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
        Schema::create('mods_trip_flyers_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->unique('motrflse_account_id');
            $table->integer('photo_id');
            $table->text('bio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_trip_flyers_settings');
    }
};
