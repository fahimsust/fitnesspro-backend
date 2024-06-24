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
        Schema::create('faqs_translations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('faqs_id')->index('fatr_content_id');
            $table->integer('language_id')->index('fatr_language_id');
            $table->string('question');
            $table->text('answer');
            $table->unique(['faqs_id', 'language_id'], 'fatr_content_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs_translations');
    }
};
