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
        Schema::table(\Domain\Payments\Models\PaymentAccount::Table(), function (Blueprint $table) {
            $table->json('credentials')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(\Domain\Payments\Models\PaymentAccount::Table(), function (Blueprint $table) {
            $table->dropColumn('credentials');
        });
    }
};
