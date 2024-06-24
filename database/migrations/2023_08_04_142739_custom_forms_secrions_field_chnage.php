<?php

use Domain\CustomForms\Models\FormSectionField;
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
        Schema::table(FormSectionField::table(), function (Blueprint $table) {
            $table->id();
            $table->boolean('required')->default(0)->change();
            $table->integer('rank')->default(0)->change();
            $table->boolean('new_row')->default(0)->change();
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
