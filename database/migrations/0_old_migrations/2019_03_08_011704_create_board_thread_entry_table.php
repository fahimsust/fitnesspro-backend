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
        Schema::create('board_thread_entry', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('thread_id')->index('thread_id');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->text('body');
            $table->dateTime('updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_thread_entry');
    }
};
