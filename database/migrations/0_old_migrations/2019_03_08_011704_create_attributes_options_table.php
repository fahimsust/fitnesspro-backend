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
        Schema::create('attributes_options', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('attribute_id')->index('attribute_id');
            $table->string('display', 100);
            $table->string('value', 100);
            $table->integer('rank');
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
        Schema::dropIfExists('attributes_options');
    }
};
