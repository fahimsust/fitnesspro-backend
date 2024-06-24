<?php

use Domain\Discounts\Models\Level\DiscountLevel;
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
        Schema::table(DiscountLevel::Table(), function (Blueprint $table) {
            $table->decimal('action_percentage', 5)->nullable()->change();
            $table->integer('action_sitepricing')->nullable()->change();
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
