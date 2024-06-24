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
        Schema::create('mods_resort_details_amenities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('resort_details_id')->index('rmoredeam_esort_id');
            $table->integer('amenity_id');
            $table->tinyInteger('details')->comment('1=included, 2=addtl cost, 3=available, 4=not available, 5=other');
            $table->unique(['resort_details_id', 'amenity_id'], 'rmoredeam_resort_amenity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_resort_details_amenities');
    }
};
