<?php

use Domain\Content\Models\Pages\Page;
use Domain\Locales\Models\Language;
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
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title', 100);
            $table->string('url_name');
            $table->longText('content')->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->unique(['page_id','language_id']);
            $table->foreign('page_id')
                ->references('id')->on(Page::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
