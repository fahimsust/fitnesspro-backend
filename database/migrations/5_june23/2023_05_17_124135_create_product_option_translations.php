<?php

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOption;
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
        Schema::create('product_option_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_option_id');
            $table->unsignedBigInteger('language_id');
            $table->string('name',100);
            $table->string('display',100);
            $table->unique(['product_option_id','language_id'],'option_language_id');
            $table->foreign('product_option_id','product_option_id_foreign')
                ->references('id')->on(ProductOption::Table())->onDelete('cascade');
            $table->foreign('language_id','option_language_id_foreign')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_transations');
    }
};
