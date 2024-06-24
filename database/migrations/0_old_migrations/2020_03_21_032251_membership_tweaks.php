<?php

use Domain\Accounts\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MembershipTweaks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn(Account::table(), 'membership_status'))
            Schema::table(Account::table(), function (Blueprint $table) {
                $table->boolean('membership_status')->default(false);
            });

//        Account::whereHas(
//            'activeMembership',
//            function ($query) {
//                $query
//                    ->whereStatus(1)
//                    ->where("start_date", "<", now()->format("Y-m-d H:i:s"))
//                    ->where("end_date", ">", now()->format("Y-m-d H:i:s"));
//            }
//        )->update(["membership_status" => true]);

        if (!Schema::hasColumn("`accounts-membership-levels`", 'auto_renewal_of'))
            Schema::table("`accounts-membership-levels`",
                function (Blueprint $table) {
                    $table->unsignedBigInteger('signupemail_customer')->nullable()->default(null)->change();
                    $table->unsignedBigInteger('renewemail_customer')->nullable()->default(null)->change();
                    $table->unsignedBigInteger('expirationalert1_email')->nullable()->default(null)->change();
                    $table->unsignedBigInteger('expirationalert2_email')->nullable()->default(null)->change();
                    $table->unsignedBigInteger('expiration_email')->nullable()->default(null)->change();

                    if (Schema::hasColumn("`accounts-membership-levels`", 'auto_renewal')) {
                        $table->dropColumn('auto_renewal');
                    }

//                    $table->unsignedBigInteger('auto_renewal_of')->nullable()->default(null);

                    DB::statement("ALTER TABLE `accounts-membership-levels` ADD `auto_renewal_of` int(11) NULL DEFAULT NULL");
                    DB::statement("ALTER TABLE `accounts-membership-levels` ADD CONSTRAINT `accounts-membership-levels_auto_renewal_of_foreign` FOREIGN KEY (`auto_renewal_of`) REFERENCES `accounts-membership-levels` (`id`)");
//                    $table->foreign('auto_renewal_of')
//                        ->references('id')
//                        ->on('`accounts-membership-levels`');
//                    $table->foreignId('auto_renewal_of')
//                        ->nullable()
//                        ->constrained(DB::self::statement("`accounts-membership-levels`"));

//                    if(!Schema::hasColumn("`accounts-membership-levels`", 'trial'))
                    DB::statement("ALTER TABLE `accounts-membership-levels` ADD `trial` TINYINT(1) NOT NULL DEFAULT '0'");
//                        $table->boolean(DB::raw('`trial`'))->default(false);
                }
            );

        if (!Schema::hasColumn('accounts_memberships', 'auto_renew'))
            Schema::table('accounts_memberships',
                function (Blueprint $table) {
                    $table->boolean('auto_renew')->default(false);
                    $table->tinyInteger('renew_payment_method')->nullable();//0=cim authnet, 1=paypal subscription
                    $table->foreignId('renew_payment_profile_id')->nullable();//link back to auth.net or paypal
                }
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
