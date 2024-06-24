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
        Schema::create('discounts_advantages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_id')->index('diad_discount_id');
            $table->integer('advantage_type_id');
            $table->decimal('flat_amount', 10);
            $table->decimal('percentage_amount', 6);
            $table->integer('product_qty');
            $table->integer('apply_shipping_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts_advantages');
    }
};
