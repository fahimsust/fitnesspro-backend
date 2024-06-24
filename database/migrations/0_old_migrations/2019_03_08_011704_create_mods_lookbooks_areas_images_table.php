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
        Schema::create('mods_lookbooks_areas_images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('temp_id');
            $table->integer('lookbook_id')->index('lookbook_id');
            $table->integer('area_id');
            $table->integer('image_id');
            $table->string('link', 155);
            $table->decimal('timing', 4, 1)->default(1.0);
            $table->boolean('static');
            $table->tinyInteger('rank');
            $table->integer('width');
            $table->integer('height');
            $table->text('content_title');
            $table->text('content_desc');
            $table->string('content_width', 10);
            $table->string('content_top', 10);
            $table->string('content_bottom', 10);
            $table->string('content_left', 10);
            $table->string('content_right', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_lookbooks_areas_images');
    }
};
