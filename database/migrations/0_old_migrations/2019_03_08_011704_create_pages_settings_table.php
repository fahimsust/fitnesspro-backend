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
        Schema::create('pages_settings', function (Blueprint $table) {
            $table->integer('page_id')->primary();
            $table->integer('settings_template_id');
            $table->integer('module_template_id');
            $table->integer('layout_id');
            $table->text('module_custom_values');
            $table->text('module_override_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_settings');
    }
};
