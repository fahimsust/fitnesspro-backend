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
        Schema::table('admin_emails_sent', function (Blueprint $table) {
            $table->string('status')->default('sent');
            $table->json('failed_data')->nullable();
            $table->timestamp('sent_date')->nullable()->change();
        });

        Schema::drop('accounts_message_keys');
        Schema::drop('orders_message_keys');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_emails_sent', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('failed_data');
            $table->timestamp('sent_date')->change();
        });
    }
};
