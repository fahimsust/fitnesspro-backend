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
        Schema::create('options_templates_options_custom', function (Blueprint $table) {
            $table->integer('value_id')->unique('value_id');
            $table->boolean('custom_type')->comment('0=text, 1=textarea, 2=color');
            $table->integer('custom_charlimit');
            $table->string('custom_label', 35);
            $table->string('custom_instruction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options_templates_options_custom');
    }
};
