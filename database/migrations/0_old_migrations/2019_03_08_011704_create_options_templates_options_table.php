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
        Schema::create('options_templates_options', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('display', 100);
            $table->integer('type_id');
            $table->boolean('show_with_thumbnail');
            $table->integer('rank');
            $table->boolean('required');
            $table->integer('template_id')->index('opteop_product_id');
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options_templates_options');
    }
};
