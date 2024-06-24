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
        Schema::create('discount_rule_condition_sites', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucosi_rule_id');
            $table->integer('site_id')->index('dirucosi_site_id');
            $table->unique(['condition_id', 'site_id'], 'dirucosi_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_sites');
    }
};
