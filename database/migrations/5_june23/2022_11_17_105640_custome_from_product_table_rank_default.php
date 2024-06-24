<?php

use Domain\CustomForms\Models\ProductForm;
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
        Schema::table(ProductForm::Table(), function (Blueprint $table) {
            $table->boolean('rank')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_table_rank_default', function (Blueprint $table) {
            //
        });
    }
};
