<?php

use Domain\Accounts\Models\AccountType;
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
        Schema::table(AccountType::Table(), function (Blueprint $table) {
            $table->integer('email_template_id_verify_email')->nullable()->change();
            $table->boolean('filter_products')->default(0)->change();
            $table->boolean('filter_categories')->default(0)->change();
            $table->boolean('use_specialties')->default(0)->change();
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
