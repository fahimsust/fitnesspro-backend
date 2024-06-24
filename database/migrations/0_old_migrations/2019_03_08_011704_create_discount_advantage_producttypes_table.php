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
        Schema::create('discount_advantage_producttypes', function (Blueprint $table) {
            $table->integer('advantage_id')->index('diadpr_advantage_id');
            $table->integer('producttype_id');
            $table->integer('applyto_qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_advantage_producttypes');
    }
};
