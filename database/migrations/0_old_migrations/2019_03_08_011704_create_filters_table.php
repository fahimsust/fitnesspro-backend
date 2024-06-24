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
        Schema::create('filters', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('label', 55);
            $table->boolean('status');
            $table->integer('rank');
            $table->boolean('show_in_search');
            $table->boolean('type')->comment('0=avail, 1=price, 2=attributes, 3=brands, 4=product types, 5=option values');
            $table->boolean('field_type')->comment('0=select,1=checkboxes');
            $table->boolean('override_parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
};
