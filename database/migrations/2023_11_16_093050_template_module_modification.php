<?php

use Domain\Modules\Models\ModuleTemplateModule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(ModuleTemplateModule::Table(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('temp_id')->nullable()->change();
            $table->integer('rank')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
