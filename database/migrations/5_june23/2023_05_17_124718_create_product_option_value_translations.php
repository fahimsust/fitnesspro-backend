<?php

use Domain\Locales\Models\Language;
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
        Schema::create('product_option_value_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_option_value_id');
            $table->unsignedBigInteger('language_id');
            $table->string('name',100);
            $table->string('display',100);
            $table->unique(['product_option_value_id','language_id'],'value_language_id');
            $table->foreign('product_option_value_id','value_id_foreign')
                ->references('id')->on('products_options_values')->onDelete('cascade');
            $table->foreign('language_id','value_language_id_foreign')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_value_transations');
    }
};
