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
        Schema::create('filters_attributes', function (Blueprint $table) {
            $table->integer('attribute_id');
            $table->integer('filter_id');
            $table->string('label', 55);
            $table->integer('rank');
            $table->boolean('status');
            $table->unique(['attribute_id', 'filter_id'], 'fiat_attribute_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters_attributes');
    }
};
