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
        Schema::create('products-rules-fulfillment_rules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_rule_id')->index('prrufuru_rule_id');
            $table->integer('child_rule_id')->index('prrufuru_child_rule_id');
            $table->unique(['parent_rule_id', 'child_rule_id'], 'prrufuru_parent_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-fulfillment_rules');
    }
};
