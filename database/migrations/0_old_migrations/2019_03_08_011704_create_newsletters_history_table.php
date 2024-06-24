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
        Schema::create('newsletters_history', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('newsletter_id')->index('newsletter_id');
            $table->string('subject', 155);
            $table->text('body');
            $table->dateTime('sent');
            $table->integer('subscribers_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletters_history');
    }
};
