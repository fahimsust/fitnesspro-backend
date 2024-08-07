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
        Schema::create('discount_rule_condition_membershiplevels', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucome_rule_id');
            $table->integer('membershiplevel_id')->index('dirucome_product_id');
            $table->unique(['condition_id', 'membershiplevel_id'], 'dirucome_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_membershiplevels');
    }
};
