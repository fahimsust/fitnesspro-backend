<?php

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
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
        Schema::table(OrderPackage::Table(), function (Blueprint $table) {
            $table->decimal('dryice_weight', 5, 1)->default(0.0)->change();
            $table->boolean('is_dryice')->default(0)->change();
            $table->integer('package_type')->default(0)->change();
            $table->integer('package_size')->default(0)->change();
        });
        Schema::table(OrderItem::Table(), function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->foreign('package_id')
                ->references('id')->on(OrderPackage::Table())->onDelete("cascade");
        });
        Schema::table("orders_shipments_labels", function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->foreign('package_id')
                ->references('id')->on(OrderPackage::Table())->onDelete("cascade");
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
