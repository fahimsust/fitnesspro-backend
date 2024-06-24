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
        Schema::create('modules-templates_modules', function (Blueprint $table) {
            $table->integer('template_id')->index('layout_id');
            $table->integer('section_id');
            $table->integer('module_id');
            $table->tinyInteger('rank');
            $table->integer('temp_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules-templates_modules');
    }
};
