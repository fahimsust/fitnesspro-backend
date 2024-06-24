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
        Schema::create('blogs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 155);
            $table->string('description', 800);
            $table->integer('createdby');
            $table->dateTime('created');
            $table->dateTime('updated');
            $table->dateTime('lastposted');
            $table->boolean('allowcomments');
            $table->integer('views');
            $table->integer('photo');
            $table->boolean('featured');
            $table->string('url_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
