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
        Schema::create('sites_payment_methods', function (Blueprint $table) {
            $table->integer('site_id')->index('sipame_site_id');
            $table->integer('payment_method_id');
            $table->integer('gateway_account_id');
            $table->decimal('fee', 8, 4)->nullable();
            $table->unique(['site_id', 'payment_method_id', 'gateway_account_id'], 'sipame_sitepaygate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_payment_methods');
    }
};
