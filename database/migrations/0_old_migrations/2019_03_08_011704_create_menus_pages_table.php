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
        Schema::create('menus_pages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('menu_id')->index('mepa_menu_id');
            $table->integer('page_id');
            $table->integer('rank');
            $table->enum('target', ['_blank', '_self', '_parent', '_top'])->default('_self');
            $table->integer('sub_pagemenu_id');
            $table->integer('sub_categorymenu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus_pages');
    }
};
