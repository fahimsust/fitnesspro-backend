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
        Schema::create('filters_availabilities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('avail_ids', 30);
            $table->integer('filter_id');
            $table->string('label', 55);
            $table->integer('rank');
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
        Schema::dropIfExists('filters_availabilities');
    }
};
