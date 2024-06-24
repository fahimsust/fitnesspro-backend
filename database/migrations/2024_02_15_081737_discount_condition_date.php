<?php

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
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
        Schema::table(DiscountCondition::Table(), function (Blueprint $table) {
            $table->dateTime('start_date')->default(null)->nullable();
            $table->dateTime('end_date')->default(null)->nullable();
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
