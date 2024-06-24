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
        Schema::create('tax_rules_locations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tax_rule_id')->index('tax_rule_id');
            $table->string('name', 55);
            $table->boolean('type')->comment('0=country, 1=state/province, 2=zipcode');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->string('zipcode', 15);
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_rules_locations');
    }
};
