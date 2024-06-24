<?php

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\Attribute;
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
        Schema::create('attribute_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('language_id');
            $table->string('name',55);
            $table->unique(['attribute_id','language_id']);
            $table->foreign('attribute_id')
                ->references('id')->on(Attribute::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_translations');
    }
};