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
        Schema::create('articles_resources', function (Blueprint $table) {
            $table->integer('article_id')->primary();
            $table->string('keywords', 500);
            $table->string('about_author', 500);
            $table->string('link_1');
            $table->string('link_2');
            $table->string('link_1_title', 65);
            $table->string('link_2_title', 65);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_resources');
    }
};
