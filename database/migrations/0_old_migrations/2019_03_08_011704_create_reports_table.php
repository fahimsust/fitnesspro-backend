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
        Schema::create('reports', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->dateTime('created');
            $table->text('criteria');
            $table->tinyInteger('type_id');
            $table->boolean('ready');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->tinyInteger('breakdown');
            $table->integer('restart');
            $table->text('variables');
            $table->timestamp('modified')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
