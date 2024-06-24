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
        Schema::create('products_settings_templates_modulevalues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('settings_template_id')->index('prsetemo_settings_template_id');
            $table->integer('section_id');
            $table->integer('module_id');
            $table->integer('field_id');
            $table->text('custom_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_settings_templates_modulevalues');
    }
};
