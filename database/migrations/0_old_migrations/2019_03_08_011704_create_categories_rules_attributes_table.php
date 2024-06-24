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
        Schema::create('categories_rules_attributes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rule_id')->index('rule_id');
            $table->integer('value_id');
            $table->integer('set_id');
            $table->tinyInteger('match_type')->comment('0=matches, 1=doesn\'t match');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_rules_attributes');
    }
};
