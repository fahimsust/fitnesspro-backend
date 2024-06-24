<?php

use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\AdminUsers\Models\User;
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
        Schema::table(AdminEmailsSent::Table(), function (Blueprint $table) {
            $table->string('sent_to', 85)->nullable()->change();

            $table->unsignedBigInteger('sent_by')->nullable()->change();
            $table->foreign('sent_by')
                ->references('id')->on(User::Table())->nullOnDelete()->change();
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
