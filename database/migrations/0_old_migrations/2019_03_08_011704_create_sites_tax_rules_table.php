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
        Schema::create('sites_tax_rules', function (Blueprint $table) {
            $table->integer('site_id')->index('sitaru_site_id');
            $table->integer('tax_rule_id');
            $table->unique(['site_id', 'tax_rule_id'], 'sitaru_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_tax_rules');
    }
};
