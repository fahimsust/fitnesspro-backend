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
        Schema::create('mods_trip_flyers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('orders_products_id')->unique('orders_products_id');
            $table->string('position', 85);
            $table->string('logo', 85)->nullable();
            $table->text('bio')->nullable();
            $table->string('name', 85);
            $table->boolean('approval_status');
            $table->dateTime('created');
            $table->integer('photo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_trip_flyers');
    }
};
