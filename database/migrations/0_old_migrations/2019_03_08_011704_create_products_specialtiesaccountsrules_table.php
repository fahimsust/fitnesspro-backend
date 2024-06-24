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
        Schema::create('products_specialtiesaccountsrules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('accounts')->index('prspacru_product_id');
            $table->string('specialties');
            $table->integer('rule_id');
            $table->unique(['accounts', 'specialties'], 'prspacru_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_specialtiesaccountsrules');
    }
};
