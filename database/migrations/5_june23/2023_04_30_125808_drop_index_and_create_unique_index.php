<?php
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Domain\Tax\Models\TaxRuleProductType;
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
        Schema::table(ProductTypeAttributeSet::Table(), function (Blueprint $table) {
            $table->unique(['type_id','set_id']);
        });
        Schema::table(TaxRuleProductType::Table(), function (Blueprint $table) {
            $table->unique(['type_id','tax_rule_id']);
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
