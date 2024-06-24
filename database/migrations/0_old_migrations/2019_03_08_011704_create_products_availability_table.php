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
        Schema::create('products-availability', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('display', 55)->nullable();
            $table->decimal('qty_min')->nullable();
            $table->decimal('qty_max')->nullable();
            $table->boolean('auto_adjust');
            $table->index(['auto_adjust', 'id', 'name'], 'products-availability_index_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-availability');
    }
};
