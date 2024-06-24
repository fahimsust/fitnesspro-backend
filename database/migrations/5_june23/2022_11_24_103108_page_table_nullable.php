<?php

use Domain\Content\Models\Pages\Page;
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
        Schema::table(Page::Table(), function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->string('meta_title',200)->nullable()->change();
            $table->string('notes',100)->nullable()->change();
            $table->string('meta_description',255)->nullable()->change();
            $table->text('meta_keywords')->nullable()->change();
            $table->boolean('status')->default(1)->change();
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
