<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('created_at')
                ->useCurrent();

            $table->timestamp('updated_at')
                ->nullable()
                ->useCurrentOnUpdate();

            $table->foreignId('affiliate_id')
                ->nullable()
                ->constrained('affiliates')
                ->nullOnDelete();

            $table->renameColumn('status', 'archived');
        });

        \Domain\Orders\Models\Order\Order::query()
            ->update([
                'created_at' => DB::raw('order_created')
            ]);

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_created');

            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('created_at', 'order_created');
            $table->dropColumn(['updated_at', 'status']);

            $table->dropForeign(['affiliate_id']);
            $table->dropColumn('affiliate_id');

            $table->renameColumn('archived', 'status');
        });
    }
};
