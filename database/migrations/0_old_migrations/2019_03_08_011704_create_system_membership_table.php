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
        Schema::create('system_membership', function (Blueprint $table) {
            $table->integer('id')->default(1)->primary();
            $table->integer('signupemail_customer');
            $table->integer('signupemail_admin');
            $table->integer('renewemail_customer');
            $table->integer('renewemail_admin');
            $table->integer('expirationalert1_days');
            $table->integer('expirationalert2_days');
            $table->integer('expirationalert1_email');
            $table->integer('expirationalert2_email');
            $table->integer('expiration_email');
            $table->integer('downgrade_restriction_days')->comment('must be within certain number of days of expiration in order to downgrade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_membership');
    }
};
