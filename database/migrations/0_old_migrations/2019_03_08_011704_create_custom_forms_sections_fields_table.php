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
        Schema::create('custom_forms_sections_fields', function (Blueprint $table) {
            $table->integer('section_id')->index('section_id');
            $table->integer('field_id');
            $table->boolean('required');
            $table->integer('rank');
            $table->boolean('new_row');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_forms_sections_fields');
    }
};
