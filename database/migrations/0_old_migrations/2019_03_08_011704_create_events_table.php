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
        Schema::create('events', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 100);
            $table->text('description');
            $table->dateTime('sdate');
            $table->dateTime('edate');
            $table->string('timezone', 155)->default('UTC');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('photo');
            $table->tinyInteger('type');
            $table->integer('type_id');
            $table->string('city', 35);
            $table->string('state', 2);
            $table->string('country', 2);
            $table->string('webaddress');
            $table->string('email', 65);
            $table->string('phone', 15);
            $table->integer('views');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
