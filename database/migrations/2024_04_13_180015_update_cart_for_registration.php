<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->boolean('is_registration')
                ->default(false);
        });

        Schema::table('cart_discount_advantages', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)
                ->nullable()
                ->change();
        });

        Schema::table('cart_item_discount_advantages', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)
                ->nullable()
                ->change();
        });

        Schema::drop('registration_discounts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
