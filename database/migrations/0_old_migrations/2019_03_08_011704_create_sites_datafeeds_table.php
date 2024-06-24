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
        Schema::create('sites_datafeeds', function (Blueprint $table) {
            $table->integer('site_id')->index('sida_site_id');
            $table->integer('datafeed_id');
            $table->boolean('parent_children');
            $table->text('custom_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_datafeeds');
    }
};
