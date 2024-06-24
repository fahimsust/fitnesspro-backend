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
        Schema::table('distributors_shipping_gateways', function (Blueprint $table) {
            $table->autoTimestamps();
            $table->json('credentials')->nullable();
            $table->json('config')->nullable();
            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributors_shipping_gateways', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('credentials');
            $table->dropColumn('config');
            $table->dropForeign(['address_id']);
            $table->dropColumn('address_id');
        });
    }
};
