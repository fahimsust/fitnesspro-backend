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
        Schema::create('discount', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('display', 85);
            $table->dateTime('start_date');
            $table->dateTime('exp_date');
            $table->boolean('status');
            $table->integer('limit_per_order')->default(1);
            $table->boolean('match_anyall')->comment('0=all, 1=any');
            $table->string('random_generated', 20);
            $table->integer('limit_uses');
            $table->integer('limit_per_customer')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount');
    }
};
