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
        Schema::create('pricing_rules_levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rule_id')->index('prrule_rule_id');
            $table->integer('min_qty');
            $table->integer('max_qty');
            $table->boolean('amount_type')->comment('0=percentage, 1=flat amount');
            $table->decimal('amount', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_rules_levels');
    }
};
