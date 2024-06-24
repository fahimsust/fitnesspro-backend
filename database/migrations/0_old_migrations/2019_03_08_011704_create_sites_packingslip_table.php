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
        Schema::create('sites_packingslip', function (Blueprint $table) {
            $table->integer('site_id')->primary();
            $table->integer('packingslip_appendix_elementid');
            $table->boolean('packingslip_showlogo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_packingslip');
    }
};
