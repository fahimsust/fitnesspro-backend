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
        Schema::create('blogs_views', function (Blueprint $table) {
            $table->integer('blog_id')->index('blvi_blog_id');
            $table->string('account_id', 10)->index('blvi_account_id');
            $table->date('viewed_date');
            $table->time('viewed_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs_views');
    }
};
