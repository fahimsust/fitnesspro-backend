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
        Schema::create('accounts_resourcebox', function (Blueprint $table) {
            $table->integer('account_id')->primary();
            $table->string('keywords');
            $table->string('about_author', 500);
            $table->string('link_1');
            $table->string('link_2');
            $table->string('link_1_title', 65);
            $table->string('link_2_title', 65);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_resourcebox');
    }
};
