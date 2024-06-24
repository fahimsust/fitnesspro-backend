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
        Schema::create('inventory_gateways_accounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_id');
            $table->string('name', 55);
            $table->string('user', 55);
            $table->string('password', 85);
            $table->string('url');
            $table->string('transkey', 500);
            $table->dateTime('last_load')->comment('Last time grabbed new products from gateway');
            $table->integer('last_load_id');
            $table->dateTime('last_update')->comment('Last time updated inventory counts from gateway');
            $table->boolean('frequency_load')->default(1)->comment('0 = every 48hrs, 1 = every 24hrs, 2= every 12hrs, 3= every 6hrs, 4= every 2hrs, 5= every hr, 6=every 30mins, 7 = every 5 mins');
            $table->boolean('frequency_update')->default(1)->comment('0 = every 48hrs, 1 = every 24hrs, 2= every 12hrs, 3= every 6hrs, 4= every 2hrs, 5= every hr, 6=every 30mins, 7 = every 5 mins');
            $table->dateTime('last_price_sync');
            $table->dateTime('last_matrix_price_sync');
            $table->boolean('update_pricing');
            $table->boolean('update_status');
            $table->boolean('update_cost');
            $table->boolean('update_weight');
            $table->boolean('create_children');
            $table->string('regular_price_field', 55);
            $table->string('sale_price_field', 55);
            $table->boolean('onsale_formula')->comment('0=none, 1=sale < reg');
            $table->boolean('use_taxinclusive_pricing');
            $table->text('custom_fields');
            $table->string('timezone', 55)->default('UTC');
            $table->string('payment_method', 85)->default('Web Credit Card|webpayment');
            $table->boolean('status')->default(1);
            $table->string('refresh_token', 85);
            $table->boolean('use_parent_inventory_id');
            $table->integer('distributor_id')->unique('ingaac_distributor_id');
            $table->integer('base_currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways_accounts');
    }
};
