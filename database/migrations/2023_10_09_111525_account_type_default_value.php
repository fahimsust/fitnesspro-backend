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
        Schema::table(AccountType::table(), function (Blueprint $table) {
            $table->integer('email_template_id_creation_admin')->nullable()->change();
            $table->integer('email_template_id_creation_user')->nullable()->change();
            $table->integer('email_template_id_activate_user')->nullable()->change();
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
