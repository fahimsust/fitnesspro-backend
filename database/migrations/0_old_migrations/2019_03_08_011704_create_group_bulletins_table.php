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
        Schema::create('group_bulletins', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('group_id');
            $table->string('subject', 155);
            $table->text('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->index(['group_id', 'createdby'], 'group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_bulletins');
    }
};
