<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        //
        Schema::table('sites_packingslip', function (Blueprint $table) {
            $table->unsignedBigInteger('packingslip_appendix_elementid')->nullable()->change();
        });
        Schema::table('search_forms_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('help_element_id')->nullable()->change();
        });
        DB::statement("UPDATE `sites_packingslip` set `packingslip_appendix_elementid` = NULL where `packingslip_appendix_elementid` = 0");
        DB::statement("UPDATE `search_forms_fields` set `help_element_id` = NULL where `help_element_id` = 0");


        Schema::table('search_forms_fields', function (Blueprint $table) {
            $table->foreign('help_element_id')
                ->references('id')->on('elements');
        });
        Schema::table('sites_packingslip', function (Blueprint $table) {
            $table->foreign('packingslip_appendix_elementid')
                ->references('id')->on('elements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
