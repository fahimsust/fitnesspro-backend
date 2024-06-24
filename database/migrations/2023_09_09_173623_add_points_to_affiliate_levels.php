<?php

use Database\Seeders\AffiliateLevelPointsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('affiliates_levels', 'affiliate_levels');

        Schema::table('affiliate_levels', function (Blueprint $table) {
            $table->autoTimestamps();
            $table->json('points')->nullable();

            $table->dropColumn(['order_rate', 'subscription_rate']);
        });

        Artisan::call('db:seed', [
            '--class' => AffiliateLevelPointsSeeder::class,
            '--force' => true,
        ]);

        Schema::table('affiliates_referrals', function (Blueprint $table) {
            $table->dropForeign('affiliates_referrals_type_id_foreign');
        });
        Schema::drop('affiliates_referrals_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
