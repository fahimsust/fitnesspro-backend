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
        Schema::create('shipping_package_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 30);
            $table->tinyInteger('carrier_id')->index('carrier_id');
            $table->string('carrier_reference', 30);
            $table->boolean('default');
            $table->tinyInteger('is_international')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_package_types');
    }
};
