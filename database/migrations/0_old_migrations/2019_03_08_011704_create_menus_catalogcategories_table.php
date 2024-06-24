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
        Schema::create('menus_catalogcategories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('menu_id')->index('menu_id');
            $table->integer('category_id');
            $table->integer('rank');
            $table->tinyInteger('submenu_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus_catalogcategories');
    }
};
