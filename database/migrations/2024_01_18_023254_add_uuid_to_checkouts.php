<?php

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
        Schema::table('checkouts', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
            $table->string('comments')->nullable();

            $table->unique('uuid');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('comments')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('comments');
        });
    }
};