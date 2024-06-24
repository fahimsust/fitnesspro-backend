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
        Schema::create('filters_pricing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('filter_id')->index('filter_id');
            $table->string('label', 55);
            $table->integer('rank');
            $table->boolean('status');
            $table->decimal('price_min')->nullable();
            $table->decimal('price_max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters_pricing');
    }
};
