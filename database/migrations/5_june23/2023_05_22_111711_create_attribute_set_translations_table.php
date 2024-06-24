<?php

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeSet;
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
        Schema::create('attribute_set_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('set_id');
            $table->unsignedBigInteger('language_id');
            $table->string('name',55);
            $table->unique(['set_id','language_id']);
            $table->foreign('set_id')
                ->references('id')->on(AttributeSet::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_set_translations');
    }
};
