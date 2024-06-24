<?php

use Domain\Orders\Models\Order\Shipments\Shipment;
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
        Schema::table(Shipment::Table(), function (Blueprint $table) {
            $table->string('ship_tracking_no', 40)->nullable()->default(null)->change();
            $table->string('signed_for_by', 55)->nullable()->default(null)->change();
            $table->string('hold_at_location_address', 250)->nullable()->default(null)->change();
            $table->string('inventory_order_id', 35)->nullable()->default(null)->change();
            $table->decimal('ship_cost', 8, 2)->default(0.00)->change();
            $table->boolean('is_downloads')->default(0)->change();
            $table->boolean('saturday_delivery')->default(0)->change();
            $table->boolean('alcohol')->default(0)->change();
            $table->boolean('dangerous_goods')->default(0)->change();
            $table->boolean('dangerous_goods_accessibility')->default(0)->change();
            $table->boolean('hold_at_location')->default(0)->change();
            $table->boolean('cod')->default(0)->change();
            $table->boolean('insured')->default(0)->change();
            $table->boolean('archived')->default(0)->change();
            $table->integer('signature_required')->default(0)->change();
            $table->integer('cod_currency')->default(0)->change();
            $table->integer('registry_id')->default(0)->change();
            $table->decimal('cod_amount', 10, 2)->default(0.00)->change();
            $table->decimal('insured_value', 10, 2)->default(0.00)->change();
            $table->unsignedBigInteger('order_status_id')->nullable()->default(null)->change();
        });
        Schema::table("accounts_loyaltypoints_credits", function (Blueprint $table) {
            $table->unsignedBigInteger('shipment_id')->nullable()->change();
            $table->dropForeign(['shipment_id']);
            $table->foreign('shipment_id')
                ->references('id')->on(Shipment::Table())-> nullOnDelete();
        });
        Schema::table("inventory_gateways_orders", function (Blueprint $table) {
            $table->unsignedBigInteger('shipment_id')->nullable()->change();
            $table->dropForeign(['shipment_id']);
            $table->foreign('shipment_id')
                ->references('id')->on(Shipment::Table())-> nullOnDelete();
        });
        Schema::table("orders_packages", function (Blueprint $table) {
            $table->dropForeign(['shipment_id']);
            $table->foreign('shipment_id')
                ->references('id')->on(Shipment::Table())->onDelete("cascade");
        });
        Schema::table("orders_shipments_labels", function (Blueprint $table) {
            $table->dropForeign(['shipment_id']);
            $table->foreign('shipment_id')
                ->references('id')->on(Shipment::Table())->onDelete("cascade");
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
