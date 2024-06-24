<?php

use Domain\Sites\Models\Layout\DisplayTemplate;
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
        Schema::table(DisplayTemplate::Table(), function (Blueprint $table) {
            $table->string('image_width', 10)->nullable()->change();
            $table->string('image_height', 10)->nullable()->change();
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
