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
        Schema::create('checkout_shipments', function (Blueprint $table) {
            $table->id();
            $table->autoTimestamps();

            $table->foreignId('checkout_id')
                ->constrained('checkouts')
                ->cascadeOnDelete();

            $table->foreignId('distributor_id')
                ->constrained('distributors')
                ->cascadeOnDelete();

            $table->foreignId('registry_id')
                ->nullable()
                ->constrained('giftregistry')
                ->cascadeOnDelete();

            $table->foreignId('shipping_method_id')
                ->nullable()
                ->constrained('shipping_methods')
                ->nullOnDelete();

            $table->decimal('shipping_cost', 10, 2)
                ->nullable();

            $table->boolean('is_drop_ship')->default(false);
            $table->boolean('is_digital')->default(false);

            $table->timestamp('rated_at')->nullable();
            $table->json('latest_rates')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_shipments');
    }
};
