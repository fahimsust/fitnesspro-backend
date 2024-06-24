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
        Schema::table('mods_resort_details', function (Blueprint $table) {
            if (! Schema::hasColumn('mods_resort_details', 'fpt_manager_id')) {
                $table->integer('fpt_manager_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mods_resort_details', function (Blueprint $table) {
            $table->dropColumn('fpt_manager_id');
        });
    }
};
