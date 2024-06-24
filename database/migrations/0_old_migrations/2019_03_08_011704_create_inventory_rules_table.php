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
        Schema::create('inventory_rules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->tinyInteger('action')->comment('0=hide, 1=change availability');
            $table->integer('min_stock_qty')->nullable();
            $table->integer('max_stock_qty')->nullable();
            $table->integer('availabity_changeto')->index('availabity_changeto');
            $table->string('label', 55);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_rules');
    }
};
