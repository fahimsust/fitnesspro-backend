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
        Schema::create('filters_productoptions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('option_name', 85);
            $table->integer('filter_id');
            $table->string('label', 55);
            $table->integer('rank');
            $table->boolean('status');
            $table->unique(['option_name', 'filter_id'], 'optionfilter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters_productoptions');
    }
};
