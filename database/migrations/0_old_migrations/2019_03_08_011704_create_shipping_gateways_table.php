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
        Schema::create('shipping_gateways', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 35);
            $table->string('classname', 100);
            $table->string('table', 35);
            $table->boolean('status')->default(0);
            $table->boolean('multipackage_support')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_gateways');
    }
};
