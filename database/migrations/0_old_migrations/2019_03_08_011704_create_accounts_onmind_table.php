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
        Schema::create('accounts_onmind', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('aon_account_id');
            $table->text('text');
            $table->dateTime('posted');
            $table->integer('like_count')->default(0);
            $table->integer('dislike_count')->default(0);
            $table->integer('comment_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_onmind');
    }
};
