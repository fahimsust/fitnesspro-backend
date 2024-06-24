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
        Schema::create('mods_lookbooks_areas', function (Blueprint $table) {
            $table->integer('lookbook_id')->index('moloar_lookbook_id');
            $table->integer('area_id');
            $table->text('text');
            $table->tinyInteger('use_static');
            $table->decimal('timing', 4, 1)->default(1.0);
            $table->boolean('show_thumbs')->default(0);
            $table->boolean('show_arrows')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_lookbooks_areas');
    }
};
