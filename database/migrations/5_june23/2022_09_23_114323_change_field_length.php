<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Domain\Affiliates\Models\Affiliate;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\AccountAddress;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            Affiliate::Table(),
            function (Blueprint $table) {
                $table->string('password', 255)->change();
                if(Schema::hasColumn($table->getTable(), 'phone'))
                    $table->string('phone', 35)->change();
            }
        );
        Schema::table(
            Subscription::Table(),
            function (Blueprint $table) {
                $table->boolean('expirealert1_sent')->default(0)->change();
                $table->boolean('expirealert2_sent')->default(0)->change();
                $table->boolean('expire_sent')->default(0)->change();
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
};
