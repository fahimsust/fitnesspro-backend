<?php

use Domain\Sites\Models\SiteMessageTemplate;
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
        Schema::table(SiteMessageTemplate::Table(), function (Blueprint $table) {
            $table->text('html')->default("{PLACEHOLDER}")->nullable()->change();
            $table->text('alt')->default("{PLACEHOLDER}")->nullable()->change();
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
