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
        Schema::create('blog_entry', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('blog_id');
            $table->binary('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('updated');
            $table->boolean('allowcomments');
            $table->string('title', 100);
            $table->string('short_title', 35);
            $table->string('subtitle');
            $table->integer('views');
            $table->integer('photo');
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
        Schema::dropIfExists('blog_entry');
    }
};
