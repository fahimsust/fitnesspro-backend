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
        Schema::table('products_options', function (Blueprint $table) {
            $table->dropForeign('products_options_type_id_foreign');
        });

        Schema::drop('products_options_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
