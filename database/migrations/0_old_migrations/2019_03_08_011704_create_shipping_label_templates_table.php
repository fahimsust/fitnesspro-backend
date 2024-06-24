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
        Schema::create('shipping_label_templates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('filename', 55);
            $table->string('required_js');
            $table->string('required_css');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_label_templates');
    }
};
