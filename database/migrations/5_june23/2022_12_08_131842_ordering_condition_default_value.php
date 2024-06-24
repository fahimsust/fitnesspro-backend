<?php

use Domain\Products\Models\OrderingRules\OrderingCondition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(OrderingCondition::Table(), function (Blueprint $table) {
            $table->boolean('status')->default(1)->change();
            $table->string('any_all',30)->nullable()->change();
        });
        Schema::table('products_rules_ordering_conditions_items', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['item_id']);
            $table->foreign('condition_id')
                ->references('id')->on('products_rules_ordering_conditions')->onDelete('cascade');
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
