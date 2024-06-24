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
        Schema::create('mods_account_certifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('mac_account_id');
            $table->string('cert_num', 35);
            $table->date('cert_exp')->nullable();
            $table->string('cert_type', 55);
            $table->string('cert_org', 55);
            $table->boolean('approval_status');
            $table->dateTime('created');
            $table->dateTime('updated');
            $table->string('file_name');
            $table->index(['account_id', 'approval_status'], 'account_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_account_certifications');
    }
};
