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
        Schema::create('products-rules-fulfillment_distributors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rule_id')->index('prrufudi_rule_id');
            $table->integer('distributor_id')->index('prrufudi_child_rule_id');
            $table->integer('rank');
            $table->unique(['rule_id', 'distributor_id'], 'prrufudi_parent_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-fulfillment_distributors');
    }
};
