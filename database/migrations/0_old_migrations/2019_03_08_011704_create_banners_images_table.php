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
        Schema::create('banners_images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('campaign_id')->index('campaign_id');
            $table->string('name', 55);
            $table->string('link');
            $table->string('image', 100);
            $table->integer('clicks_no');
            $table->integer('show_no');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners_images');
    }
};
