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
        Schema::create('accounts_messages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('header_id');
            $table->integer('replied_id');
            $table->integer('to_id');
            $table->integer('from_id');
            $table->text('body');
            $table->dateTime('sent');
            $table->dateTime('readdate');
            $table->boolean('status')->default(0)->comment('1=deleted, 2=spam, 3=saved');
            $table->boolean('beenseen')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_messages');
    }
};
