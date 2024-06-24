<?php

use Domain\Products\Models\Product\Option\ProductOptionValue;
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
        Schema::table(ProductOptionValue::Table(), function (Blueprint $table) {
            $table->integer('rank')->default(0)->change();
            $table->boolean('is_custom')->default(0)->change();
            $table->decimal('price')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
