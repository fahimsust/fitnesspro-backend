<?php

use Domain\CustomForms\Models\FormSection;
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
        Schema::create('custom_form_section_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title', 155);

            $table->unique(['section_id','language_id']);
            $table->foreign('section_id')
                ->references('id')->on(FormSection::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_form_section_translations');
    }
};
