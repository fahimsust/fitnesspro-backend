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
        Schema::create('accounts_onmind_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('onmind_id');
            $table->integer('comment_id');
            $table->integer('account_id');
            $table->string('text', 200);
            $table->dateTime('posted');
            $table->index(['onmind_id', 'comment_id', 'account_id'], 'onmind_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_onmind_comments');
    }
};
