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
        Schema::create('friends_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('friend_id')->index('friend_id');
            $table->tinyInteger('type');
            $table->integer('type_id');
            $table->integer('num');
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
        Schema::dropIfExists('friends_updates');
    }
};
