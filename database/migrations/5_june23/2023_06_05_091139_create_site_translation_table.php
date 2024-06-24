<?php

use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
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
        Schema::create('site_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('language_id');
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_desc',500)->nullable();
            $table->string('meta_keywords',255)->nullable();
            $table->text('offline_message')->nullable();
            $table->unique(['site_id','language_id']);
            $table->foreign('site_id')
                ->references('id')->on(Site::Table())->onDelete('cascade');
            $table->foreign('language_id')
                ->references('id')->on(Language::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_translation');
    }
};
