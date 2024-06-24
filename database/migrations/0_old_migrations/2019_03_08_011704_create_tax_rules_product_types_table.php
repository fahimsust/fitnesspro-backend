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
        Schema::create('tax_rules_product-types', function (Blueprint $table) {
            $table->integer('tax_rule_id');
            $table->integer('type_id')->index('taruprty_type_id');
            $table->unique(['tax_rule_id', 'type_id'], 'taruprty_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_rules_product-types');
    }
};
