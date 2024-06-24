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
        Schema::create('accounts_onmind_likes', function (Blueprint $table) {
            $table->integer('onmind_id');
            $table->integer('account_id');
            $table->boolean('type_id');
            $table->index(['onmind_id', 'account_id'], 'aon_onmind_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_onmind_likes');
    }
};
