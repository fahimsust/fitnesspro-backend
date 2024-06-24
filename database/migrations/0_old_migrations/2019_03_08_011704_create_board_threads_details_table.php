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
        Schema::create('board_threads_details', function (Blueprint $table) {
            $table->integer('thread_id')->primary();
            $table->string('keywords', 500);
            $table->string('city', 35);
            $table->string('state', 2);
            $table->string('country', 2);
            $table->string('zipcode', 15);
            $table->string('webaddress', 100);
            $table->string('email', 85);
            $table->string('phone', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_threads_details');
    }
};
