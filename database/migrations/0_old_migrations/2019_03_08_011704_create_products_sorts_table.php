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
        Schema::create('products_sorts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('orderby', 55);
            $table->string('sortby', 10);
            $table->boolean('status');
            $table->integer('rank');
            $table->boolean('isdefault');
            $table->string('display', 55)->nullable();
            $table->boolean('categories_only')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_sorts');
    }
};
