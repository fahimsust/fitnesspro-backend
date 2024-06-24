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
        Schema::create('display_templates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('type_id');
            $table->string('name', 55);
            $table->string('include');
            $table->string('image_width', 10);
            $table->string('image_height', 10);
            $table->index(['include', 'image_width', 'image_height'], 'display_templates_index_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('display_templates');
    }
};
