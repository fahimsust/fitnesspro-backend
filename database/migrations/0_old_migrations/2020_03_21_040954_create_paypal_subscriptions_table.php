<?php

use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaypalSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //create table to track paypal subscriptions
        Schema::create('paypal_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->integer('gateway_account_id');
            $table->unsignedBigInteger('paypal_subscription_id');
            $table->string('approval_link');
            $table->tinyInteger('status');
            /*APPROVAL_PENDING. The subscription is created but not yet approved by the buyer.
APPROVED. The buyer has approved the subscription.
ACTIVE. The subscription is active.
SUSPENDED. The subscription is suspended.
CANCELLED. The subscription is cancelled.
EXPIRED. The subscription is expired.*/
        });

        if(!Schema::hasColumn("`accounts-membership-levels`", 'paypal_plan_id'))
            DB::statement("ALTER TABLE `accounts-membership-levels` ADD `paypal_plan_id` VARCHAR(85) NULL DEFAULT NULL");
//            Schema::table("`accounts-membership-levels`", function (Blueprint $table) {
//                $table->string('paypal_plan_id')->nullable();
//            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_subscriptions');
    }
}
