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
        Schema::create('faqs-categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title');
            $table->boolean('status');
            $table->integer('rank');
            $table->string('url', 85);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs-categories');
    }
};
