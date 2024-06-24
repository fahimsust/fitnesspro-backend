<?php

use Domain\Locales\Models\Language;
use Domain\Messaging\Models\MessageTemplate;
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
        Schema::create('message_template_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_template_id');
            $table->unsignedBigInteger('language_id');
            $table->string('subject', 255);
            $table->text('html_body');
            $table->text('alt_body');

            $table->unique(['message_template_id', 'language_id'], 'fk_message_template_id_lang_id');
            $table->foreign('message_template_id')
                ->references('id')->on(MessageTemplate::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
