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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('name', 80)->default('')->unique('shme_name');
            $table->string('display', 155);
            $table->char('refname', 85)->default('');
            $table->string('carriercode', 55);
            $table->boolean('status');
            $table->decimal('price', 6);
            $table->tinyInteger('rank')->default(0);
            $table->tinyInteger('ships_residential')->comment('0 = ships both, 1= residential only, 2=commercial only');
            $table->integer('carrier_id');
            $table->decimal('weight_limit', 6);
            $table->decimal('weight_min', 6);
            $table->boolean('is_international')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
};
