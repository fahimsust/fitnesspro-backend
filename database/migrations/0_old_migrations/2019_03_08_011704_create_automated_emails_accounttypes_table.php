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
        Schema::create('automated_emails_accounttypes', function (Blueprint $table) {
            $table->integer('automated_email_id')->index('automated_email_id');
            $table->integer('account_type_id')->index('account_type_id');
            $table->unique(['automated_email_id', 'account_type_id'], 'automated_email_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automated_emails_accounttypes');
    }
};
