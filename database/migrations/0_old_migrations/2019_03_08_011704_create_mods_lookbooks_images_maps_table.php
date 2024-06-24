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
        Schema::create('mods_lookbooks_images_maps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eimage_id');
            $table->boolean('shape');
            $table->text('coord');
            $table->string('href');
            $table->tinyInteger('target');
            $table->string('title');
            $table->text('description');
            $table->boolean('popup_position');
            $table->integer('popup_offsetx');
            $table->integer('popup_offsety');
            $table->integer('popup_width')->default(200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_lookbooks_images_maps');
    }
};
