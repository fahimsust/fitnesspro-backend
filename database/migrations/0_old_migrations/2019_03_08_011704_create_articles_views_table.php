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
        Schema::create('articles_views', function (Blueprint $table) {
            $table->integer('article_id');
            $table->integer('account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
            $table->index(['article_id', 'account_id'], 'article_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_views');
    }
};
