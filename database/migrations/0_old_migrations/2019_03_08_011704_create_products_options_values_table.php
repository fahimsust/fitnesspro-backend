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
        Schema::create('products_options_values', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('option_id')->index('propva_option_id');
            $table->string('name', 100);
            $table->string('display', 100);
            $table->decimal('price');
            $table->integer('rank');
            $table->integer('image_id');
            $table->boolean('is_custom');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('status')->default(1)->index('propva_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_options_values');
    }
};
