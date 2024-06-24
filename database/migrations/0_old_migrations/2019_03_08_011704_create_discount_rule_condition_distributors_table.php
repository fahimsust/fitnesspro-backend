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
        Schema::create('discount_rule_condition_distributors', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucodi_rule_id');
            $table->integer('distributor_id')->index('dirucodi_site_id');
            $table->unique(['condition_id', 'distributor_id'], 'dirucodi_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_distributors');
    }
};
