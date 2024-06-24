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
        Schema::create('loyaltypoints_levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('loyaltypoints_id')->index('loyaltypoints_id');
            $table->tinyInteger('points_per_dollar')->default(1);
            $table->decimal('value_per_point', 5)->default(0.01);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loyaltypoints_levels');
    }
};
