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
        Schema::create('catalog_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 5)->comment('0=product, 1=category, 2=new image size, 5-5.99=datafeed, 6=sitemap, 7=notify backinstock');
            $table->integer('item_id')->index('item_id');
            $table->boolean('processing');
            $table->integer('start');
            $table->text('info');
            $table->integer('modified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_updates');
    }
};
