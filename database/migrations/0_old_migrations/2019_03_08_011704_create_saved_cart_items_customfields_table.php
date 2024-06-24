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
        Schema::create('saved_cart_items_customfields', function (Blueprint $table) {
            $table->integer('saved_cart_item_id');
            $table->integer('form_id');
            $table->integer('section_id');
            $table->integer('field_id');
            $table->text('value');
            $table->unique(['saved_cart_item_id', 'form_id', 'section_id', 'field_id'], 'saved_cart_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_cart_items_customfields');
    }
};
