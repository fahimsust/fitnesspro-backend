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
        Schema::create('mods_account_files', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id');
            $table->string('filename', 85);
            $table->dateTime('uploaded');
            $table->integer('site_id');
            $table->boolean('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_account_files');
    }
};
