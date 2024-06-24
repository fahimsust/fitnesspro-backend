<?php

use Domain\Products\Models\Category\CategorySettingsTemplate;
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
        Schema::table(CategorySettingsTemplate::Table(), function (Blueprint $table) {
            $table->integer('layout_id_default')->nullable();
            $table->integer('module_template_id_default')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
