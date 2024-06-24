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
        Schema::create('affiliates_referrals', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('affiliate_id')->index('aref_affiliate_id');
            $table->integer('order_id')->index('aref_order_id');
            $table->integer('status_id');
            $table->decimal('amount', 15);
            $table->integer('type_id')->index('aref_type_id');
            $table->index(['order_id', 'type_id'], 'aref_ordertype_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates_referrals');
    }
};
