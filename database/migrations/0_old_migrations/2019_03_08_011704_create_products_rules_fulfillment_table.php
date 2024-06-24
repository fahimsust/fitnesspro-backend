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
        Schema::create('products-rules-fulfillment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 85);
            $table->boolean('status');
            $table->enum('any_all', ['any', 'all']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-fulfillment');
    }
};
