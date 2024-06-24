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
        Schema::create('system_tasks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('site_id');
            $table->boolean('type')->comment('0=download update');
            $table->string('type_info')->comment('type = 0: download url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_tasks');
    }
};
