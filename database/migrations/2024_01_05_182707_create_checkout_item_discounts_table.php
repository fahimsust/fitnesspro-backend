<?php

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
        Schema::create('checkout_item_discounts', function (Blueprint $table) {
            $table->id();
            $table->autoTimestamps();

            $table->foreignId('checkout_item_id')
                ->constrained('checkout_items')
                ->cascadeOnDelete();

            $table->foreignId('advantage_id')
                ->constrained('discount_advantage')
                ->cascadeOnDelete();

            $table->foreignId('discount_id')
                ->constrained('discount')
                ->cascadeOnDelete();

            $table->unsignedInteger('qty');
            $table->string('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_item_discounts');
    }
};
