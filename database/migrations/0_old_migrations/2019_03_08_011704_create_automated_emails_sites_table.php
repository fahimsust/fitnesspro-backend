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
        Schema::create('automated_emails_sites', function (Blueprint $table) {
            $table->integer('automated_email_id')->index('aues_automated_email_id');
            $table->integer('site_id')->index('aues_site_id');
            $table->unique(['automated_email_id', 'site_id'], 'aues_automated_email_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automated_emails_sites');
    }
};
