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
        Schema::create('system_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('site_id')->index('syup_site_id');
            $table->string('version', 25);
            $table->tinyInteger('type')->comment('0=download, 1=run update');
            $table->boolean('processing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_updates');
    }
};
