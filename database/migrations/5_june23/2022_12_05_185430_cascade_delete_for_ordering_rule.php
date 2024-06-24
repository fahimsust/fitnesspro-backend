<?php

use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRuleAction;
use Domain\Products\Models\OrderingRules\OrderingCondition;
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
        Schema::table(DatesAutoOrderRuleAction::Table(), function (Blueprint $table) {
            $table->dropForeign('criteria_order_rule_id');
            $table->dropForeign('changeto_order_rule_id');

            $table->foreign('criteria_orderingruleid', 'criteria_order_rule_id')
              ->references('id')->on('products_rules_ordering')->onDelete('cascade');
            $table->foreign('changeto_orderingruleid', 'changeto_order_rule_id')
                ->references('id')->on('products_rules_ordering')->onDelete('cascade');

        });
        Schema::table(OrderingCondition::Table(), function (Blueprint $table) {
            $table->dropForeign(['rule_id']);
            $table->foreign('rule_id')
                ->references('id')->on('products_rules_ordering')->onDelete('cascade');
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
