<?php

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Product;
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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title',500);
            $table->string('subtitle')->nullable();
            $table->string('url_name')->unique();
            $table->string('meta_title', 155)->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('customs_description')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('description')->nullable();
            $table->unique(['product_id','language_id']);
            $table->foreign('product_id')
                ->references('id')->on(Product::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('product_details_translations');
    }
};
