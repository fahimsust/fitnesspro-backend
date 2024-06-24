<?php

use Domain\Products\Models\Product\ProductImage;
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
        Schema::table(ProductImage::Table(), function (Blueprint $table) {
            $table->id();
            $table->string('caption',55)->nullable()->change();
            $table->boolean('rank')->nullable()->default(null)->change();
            $table->boolean('show_in_gallery')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_image', function (Blueprint $table) {
            //
        });
    }
};
