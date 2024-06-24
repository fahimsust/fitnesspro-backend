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
        Schema::create('accounts_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('acomm_account_id');
            $table->text('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->boolean('beenread')->default(0);
            $table->integer('replyto_id')->index('replyto_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_comments');
    }
};
