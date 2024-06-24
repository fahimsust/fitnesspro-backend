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
        Schema::create('accounts-membership-levels_settings', function (Blueprint $table) {
            $table->integer('level_id', true);
            $table->integer('badge');
            $table->integer('search_limit');
            $table->integer('event_limit');
            $table->integer('ad_limit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-membership-levels_settings');
    }
};
