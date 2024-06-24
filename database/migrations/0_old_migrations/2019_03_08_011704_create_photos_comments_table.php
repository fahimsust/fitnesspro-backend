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
        Schema::create('photos_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('photo_id')->index('photo_id');
            $table->text('body');
            $table->integer('account_id');
            $table->dateTime('created');
            $table->boolean('beenread')->default(0)->index('read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos_comments');
    }
};
