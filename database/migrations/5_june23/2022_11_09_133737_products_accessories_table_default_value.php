<?php

use Domain\Products\Models\Product\ProductAccessory;
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
        Schema::table(ProductAccessory::Table(), function (Blueprint $table) {
            $table->boolean('discount_percentage')->default(0)->nullable()->change();
            $table->boolean('link_actions')->default(0)->nullable()->change();
            $table->string('description',255)->nullable()->change();
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
