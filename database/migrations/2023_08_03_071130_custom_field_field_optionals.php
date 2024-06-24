<?php

use Domain\CustomForms\Models\CustomField;
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
        //
        Schema::table(CustomField::table(), function (Blueprint $table) {
            $table->string('cssclass',100)->nullable()->change();
            $table->text('options')->nullable()->change();
            $table->text('specs')->nullable()->change();
            $table->boolean('type')->default(0)->change();
            $table->boolean('status')->default(1)->change();
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
