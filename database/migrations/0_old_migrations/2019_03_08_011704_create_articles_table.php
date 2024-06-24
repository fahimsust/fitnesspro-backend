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
        Schema::create('articles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('headline');
            $table->string('short_headline', 35);
            $table->string('author', 155);
            $table->longText('body');
            $table->integer('photo');
            $table->integer('account_id');
            $table->dateTime('created');
            $table->dateTime('updated');
            $table->integer('category');
            $table->integer('views')->index('rank');
            $table->boolean('featured');
            $table->string('url_name', 55);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
