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
        Schema::create('mods_lookbooks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 155);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('config_id', 55);
            $table->boolean('status');
            $table->boolean('default_status');
            $table->text('header_text');
            $table->text('footer_text');
            $table->string('meta_title');
            $table->string('meta_desc');
            $table->string('meta_keywords');
            $table->integer('galleries_thumbnail');
            $table->enum('plugin_type', ['tn3', 'cycle2'])->default('tn3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_lookbooks');
    }
};
