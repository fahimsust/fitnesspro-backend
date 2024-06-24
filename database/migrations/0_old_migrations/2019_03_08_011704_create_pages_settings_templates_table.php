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
        Schema::create('pages_settings_templates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->integer('layout_id')->nullable();
            $table->integer('module_template_id')->nullable();
            $table->integer('settings_template_id')->nullable();
            $table->text('module_custom_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_settings_templates');
    }
};
