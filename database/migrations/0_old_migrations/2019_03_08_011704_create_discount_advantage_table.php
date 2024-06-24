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
        Schema::create('discount_advantage', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_id')->index('discount_id');
            $table->integer('advantage_type_id');
            $table->decimal('amount', 10);
            $table->integer('apply_shipping_id');
            $table->integer('apply_shipping_country');
            $table->integer('apply_shipping_distributor');
            $table->boolean('applyto_qty_type')->comment('0=combined,1=individual');
            $table->integer('applyto_qty_combined')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_advantage');
    }
};
