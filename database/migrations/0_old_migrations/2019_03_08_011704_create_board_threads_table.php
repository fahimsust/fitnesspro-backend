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
        Schema::create('board_threads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id');
            $table->string('name');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('updated');
            $table->integer('updatedby');
            $table->boolean('allowreply')->default(1);
            $table->dateTime('lastpost');
            $table->integer('lastposter');
            $table->integer('photo');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_threads');
    }
};
