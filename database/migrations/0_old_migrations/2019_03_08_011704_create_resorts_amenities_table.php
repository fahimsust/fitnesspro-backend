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
        Schema::create('resorts_amenities', function (Blueprint $table) {
            $table->integer('resort_id')->index('resort_id');
            $table->integer('amenity_id');
            $table->tinyInteger('details')->comment('1=included, 2=addtl cost, 3=available, 4=not available, 5=other');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resorts_amenities');
    }
};
