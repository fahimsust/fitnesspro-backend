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
        Schema::create('languages_translations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('content_id')->index('latr_content_id');
            $table->integer('language_id')->index('latr_language_id');
            $table->text('msgstr');
            $table->boolean('status')->default(1);
            $table->unique(['content_id', 'language_id'], 'latr_content_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages_translations');
    }
};
