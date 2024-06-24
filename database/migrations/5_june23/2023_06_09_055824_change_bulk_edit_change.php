<?php

use Domain\Products\Models\BulkEdit\BulkEditActivity;
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
        Schema::table(BulkEditActivity::Table(), function (Blueprint $table) {
            $table->string('action_changeto',255)->nullable()->change();
        });
        BulkEditActivity::query()->update(['action_changeto' => null]);

        Schema::table(BulkEditActivity::table(), function (Blueprint $table) {
            $table->integer('action_type')->change();
            $table->json("action_changeto")->change();
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
