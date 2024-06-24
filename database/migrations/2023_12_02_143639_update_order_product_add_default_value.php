<?php

use Domain\Orders\Models\Order\OrderItems\OrderItem;
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
        Schema::table(OrderItem::Table(), function (Blueprint $table) {
            $table->string('product_notes', 255)->nullable()->default(null)->change();
            $table->string('product_label', 155)->nullable()->default(null)->change();
            $table->integer('free_from_discount_advantage')->default(0)->change();
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
