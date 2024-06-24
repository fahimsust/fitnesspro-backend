<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_gateways_sites', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_account_id');
            $table->integer('site_id')->index('ingasi_site_id');
            $table->boolean('update_pricing');
            $table->decimal('pricing_adjustment');
            $table->boolean('update_status');
            $table->boolean('publish_on_import')->default(1);
            $table->string('regular_price_field', 55);
            $table->string('sale_price_field', 55);
            $table->boolean('onsale_formula')->comment('0=none, 1=sale < reg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways_sites');
    }
};
