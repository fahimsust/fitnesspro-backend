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
        Schema::create('newsletters_subscribers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('newsletter_id')->index('nesu_newsletter_id');
            $table->string('name', 85);
            $table->string('email', 85);
            $table->dateTime('joined');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletters_subscribers');
    }
};
