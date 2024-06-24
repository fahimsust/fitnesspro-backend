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
        Schema::create('mods_dates_auto_orderrules_action', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('dao_id')->index('dao_id');
            $table->integer('criteria_startdatewithindays');
            $table->integer('criteria_orderingruleid')->nullable();
            $table->integer('criteria_siteid')->nullable();
            $table->integer('changeto_orderingruleid');
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
        Schema::dropIfExists('mods_dates_auto_orderrules_action');
    }
};
