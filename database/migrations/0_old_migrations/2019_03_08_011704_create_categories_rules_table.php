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
        Schema::create('categories_rules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id');
            $table->integer('temp_id');
            $table->boolean('match_type')->comment('0=any, 1=all');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_rules');
    }
};
