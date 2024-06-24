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
        Schema::create('payment_methods_limitcountries', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('payment_method_id');
            $table->integer('country_id');
            $table->decimal('fee', 8, 4)->nullable();
            $table->boolean('limiting');
            $table->unique(['payment_method_id', 'country_id'], 'payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods_limitcountries');
    }
};
