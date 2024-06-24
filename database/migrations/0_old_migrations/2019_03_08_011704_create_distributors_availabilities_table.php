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
        Schema::create('distributors_availabilities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('distributor_id');
            $table->integer('availability_id');
            $table->string('display', 55)->nullable();
            $table->decimal('qty_min')->nullable();
            $table->decimal('qty_max')->nullable();
            $table->unique(['distributor_id', 'availability_id'], 'distavail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_availabilities');
    }
};
