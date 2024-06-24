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
        Schema::create('modules_crons', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('module_id')->index('mocr_module_id');
            $table->boolean('type')->index('type');
            $table->string('function', 55);
            $table->dateTime('last_run');
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules_crons');
    }
};
