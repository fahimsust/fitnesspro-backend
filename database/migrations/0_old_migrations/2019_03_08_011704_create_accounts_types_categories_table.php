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
        Schema::create('accounts-types_categories', function (Blueprint $table) {
            $table->integer('type_id')->index('atypec_type_id_2');
            $table->integer('category_id')->index('atypec_product_id');
            $table->unique(['type_id', 'category_id'], 'atypec_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-types_categories');
    }
};
