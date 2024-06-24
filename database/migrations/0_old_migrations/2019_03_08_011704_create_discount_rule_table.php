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
        Schema::create('discount_rule', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_id')->index('diru_discount_id');
            $table->boolean('match_anyall')->comment('0=all, 1=any');
            $table->integer('rank')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule');
    }
};
