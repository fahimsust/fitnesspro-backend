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
        Schema::create('accounts_views', function (Blueprint $table) {
            $table->integer('profile_id')->index('aviews_profile_id');
            $table->integer('account_id')->index('aviews_account_id')->comment('viewers id');
            $table->date('viewed_date');
            $table->time('viewed_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_views');
    }
};
