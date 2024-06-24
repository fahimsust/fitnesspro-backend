<?php

use Domain\Sites\Enums\RequireLogin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('require_login_for', 10)
                ->default(RequireLogin::None->value);
        });

        DB::table('sites')
            ->where('require_login', 1)
            ->update([
                'require_login_for' => RequireLogin::Site->value,
            ]);
        DB::table('sites')
            ->where('require_login', 2)
            ->update([
                'require_login_for' => RequireLogin::Catalog->value,
            ]);
        DB::table('sites')
            ->join(
                'sites_settings',
                'sites.id',
                '=',
                'sites_settings.site_id'
            )
            ->where('sites_settings.require_customer_account', 1)
            ->where('sites.require_login', '!=', 0)
            ->update([
                'sites.require_login_for' => RequireLogin::Checkout->value,
            ]);

        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('require_login');
            $table->renameColumn('require_login_for', 'require_login');
        });

        Schema::table('sites_settings', function (Blueprint $table) {
            $table->dropColumn('require_customer_account');
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
