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
        Schema::create('modules_site_controllers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('module_id')->index('mosico_module_id');
            $table->string('controller_section', 155);
            $table->boolean('showinmenu');
            $table->string('menu_label', 55);
            $table->string('menu_link', 85);
            $table->string('url_name', 55);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules_site_controllers');
    }
};
