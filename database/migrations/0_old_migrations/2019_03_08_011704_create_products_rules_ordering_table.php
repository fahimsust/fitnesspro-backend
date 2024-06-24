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
        Schema::create('products-rules-ordering', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 85);
            $table->boolean('status');
            $table->enum('any_all', ['any', 'all']);
            $table->index(['status', 'id', 'name'], 'products-rules-ordering_index_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-ordering');
    }
};
