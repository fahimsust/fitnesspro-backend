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
        Schema::create('group_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('group_id');
            $table->tinyInteger('type');
            $table->integer('type_id');
            $table->dateTime('updated');
            $table->integer('friend_id');
            $table->integer('num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_updates');
    }
};
