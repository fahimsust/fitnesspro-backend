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
        Schema::create('faqs-categories_translations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('categories_id')->index('content_id');
            $table->integer('language_id')->index('language_id');
            $table->string('title');
            $table->unique(['categories_id', 'language_id'], 'content_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs-categories_translations');
    }
};
