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
        Schema::create('discounts-levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->tinyInteger('apply_to')->comment('0=all products, 1=selected products, 2=not selected products');
            $table->boolean('action_type')->comment('0=percentage, 1=site pricing');
            $table->decimal('action_percentage', 5);
            $table->integer('action_sitepricing');
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
        Schema::dropIfExists('discounts-levels');
    }
};
