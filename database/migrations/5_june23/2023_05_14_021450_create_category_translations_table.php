<?php

use Domain\Locales\Models\Language;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('url_name',155);
            $table->longText('description')->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_desc')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->unique(['category_id','language_id']);
            $table->foreign('category_id')
                ->references('id')->on(Category::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};
