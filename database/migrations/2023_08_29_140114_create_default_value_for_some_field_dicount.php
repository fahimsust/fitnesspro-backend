<?php

use Domain\Discounts\Models\Discount;
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
        Schema::table(Discount::table(), function (Blueprint $table) {
            $table->integer('limit_uses')->default(0)->change();
            $table->boolean('match_anyall')->default(0)->change();
            $table->boolean('match_anyall')->default(0)->change();
            $table->boolean('limit_per_customer')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_value_for_some_field_dicount');
    }
};
