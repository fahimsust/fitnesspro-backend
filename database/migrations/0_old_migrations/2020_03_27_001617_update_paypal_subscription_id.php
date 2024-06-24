<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdatePaypalSubscriptionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `paypal_subscriptions` CHANGE `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");

        Schema::table('paypal_subscriptions', function (Blueprint $table) {
            $table->string('paypal_subscription_id', 85)->change();
            $table->timestamp('activated_at')->nullable()->default(null);
            $table->string('order_no');
        });
    }
}
