<?php

use Domain\Resorts\Models\Resort;
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
            $table->string('fee_total', 155)->nullable();
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
            $table->dropColumn('fee_total');
        });
    }
};
