<?php

use Domain\CustomForms\Models\ProductForm;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Products\Models\Product\ProductDistributor;
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
        if(!Schema::hasColumn(ProductForm::Table(), 'id'))
            Schema::table(ProductForm::Table(), function (Blueprint $table) {
                $table->id();
            });

        if(!Schema::hasColumn(ProductAccessory::Table(), 'id'))
            Schema::table(ProductAccessory::Table(), function (Blueprint $table) {
                $table->id();
            });

        Schema::table(ProductDistributor::Table(), function (Blueprint $table) {
            $table->unsignedBigInteger('outofstockstatus_id')->change();
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
