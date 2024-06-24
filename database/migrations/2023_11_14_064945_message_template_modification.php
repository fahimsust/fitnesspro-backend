<?php

use Domain\Messaging\Models\MessageTemplate;
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
        Schema::table(MessageTemplate::Table(), function (Blueprint $table) {
            $table->string('note', 255)->nullable()->change();
            $table->string('system_id', 85)->nullable()->change();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained(Category::Table())
                ->nullOnDelete();
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
