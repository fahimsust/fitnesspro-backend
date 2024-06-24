<?php

use Domain\Accounts\Models\AccountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrialFlagToAccountTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `accounts-types` ADD `is_trial` TINYINT(1) NOT NULL DEFAULT '0';");
//        Schema::table("`accounts-types`", function (Blueprint $table) {
//            $table->boolean("is_trial")->default(false);
//        });
    }
}
