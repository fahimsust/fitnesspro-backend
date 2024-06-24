<?php

use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingRule;
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
        Schema::table(OrderingCondition::Table(), function (Blueprint $table) {
            $table->dropForeign('products_rules_ordering_conditions_rule_id_foreign');
        });

        Schema::table(OrderingCondition::Table(), function (Blueprint $table) {
            $table->foreign('rule_id')
                ->on(OrderingRule::Table())
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
