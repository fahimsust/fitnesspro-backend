<?php

use Domain\Accounts\Models\Membership\MembershipLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `accounts-membership-levels` ADD `auto_renew_reward` BIGINT(20) UNSIGNED NULL DEFAULT NULL;");
//        Schema::table("`accounts-membership-levels`", function (Blueprint $table) {
//            $table->unsignedBigInteger('auto_renew_reward')->nullable()->default(null);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("`accounts-membership-levels`", function (Blueprint $table) {
            //
        });
    }
};
