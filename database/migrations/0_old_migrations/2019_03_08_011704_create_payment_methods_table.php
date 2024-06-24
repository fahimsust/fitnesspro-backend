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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('display', 55);
            $table->integer('gateway_id');
            $table->boolean('status');
            $table->string('template', 55)->nullable();
            $table->boolean('limitby_country')->comment('0=no,1=billing,2=shipping,3=billing not,4=shipping not');
            $table->boolean('feeby_country')->comment('0=billing, 1=shipping');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
