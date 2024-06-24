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
        Schema::create('currencies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 35);
            $table->string('code', 8);
            $table->boolean('status')->default(1);
            $table->decimal('exchange_rate', 12, 5);
            $table->boolean('exchange_api');
            $table->boolean('base');
            $table->boolean('decimal_places');
            $table->string('decimal_separator', 1)->default('.');
            $table->string('locale_code', 8);
            $table->string('format', 10)->nullable();
            $table->string('symbol', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
