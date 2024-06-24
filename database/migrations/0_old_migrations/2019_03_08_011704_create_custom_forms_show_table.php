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
        Schema::create('custom_forms_show', function (Blueprint $table) {
            $table->integer('form_id')->index('cufosh_form_id');
            $table->tinyInteger('show_on')->comment('0=checkout, 1=product details');
            $table->tinyInteger('show_for')->comment('0=all, 1=product types, 2=product id');
            $table->tinyInteger('show_count')->comment('0=once, 1=per product, 2=per product qty, 3=per type in cart');
            $table->integer('rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_forms_show');
    }
};
