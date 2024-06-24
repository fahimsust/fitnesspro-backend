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
        Schema::create('banners_campaigns', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('location', 100);
            $table->integer('width');
            $table->integer('height');
            $table->boolean('new_window');
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
        Schema::dropIfExists('banners_campaigns');
    }
};
