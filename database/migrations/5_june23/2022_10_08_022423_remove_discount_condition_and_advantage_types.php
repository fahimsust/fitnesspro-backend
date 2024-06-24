<?php

use Domain\Discounts\Models\Advantage\AdvantageType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\Condition\DiscountConditionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use \Support\Traits\HasMigrationUtilities;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if($this->hasForeignKey(DiscountCondition::Table(), 'discount_rule_condition_condition_type_id_foreign'))
            Schema::table(DiscountCondition::Table(), function (Blueprint $table) {
                $table->dropForeign('discount_rule_condition_condition_type_id_foreign');
            });

        if($this->hasForeignKey(DiscountAdvantage::Table(), 'discount_advantage_advantage_type_id_foreign'))
        Schema::table(DiscountAdvantage::Table(), function (Blueprint $table) {
            $table->dropForeign('discount_advantage_advantage_type_id_foreign');
        });

        Schema::dropIfExists('discount_advantage_types');
        Schema::dropIfExists('discount_rule_condition_types');

        Schema::table(\Domain\Discounts\Models\Discount::Table(), function (Blueprint $table) {
            $table->string('random_generated', 20)->nullable()->change();
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
