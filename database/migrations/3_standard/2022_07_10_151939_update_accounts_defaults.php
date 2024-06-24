<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = \Domain\Accounts\Models\Account::Table();

        DB::statement("ALTER TABLE {$table} CHANGE created_at created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        DB::statement("ALTER TABLE {$table} CHANGE lastlogin_at lastlogin_at TIMESTAMP NULL DEFAULT NULL");
        DB::statement("ALTER TABLE {$table} CHANGE last_verify_attempt_date last_verify_attempt_date DATE NULL DEFAULT NULL");

        Schema::table(
            $table,
            function (Blueprint $table) {
                $table->string('phone')
                    ->nullable()
                    ->change();

                $table->text('admin_notes')
                    ->nullable()
                    ->change();

                $table->boolean('send_verify_email')
                    ->default(false)
                    ->change();

                foreach ([
                    'default_billing_id',
                    'default_shipping_id',
                    'affiliate_id',
                    'cim_profile_id',
                    'photo_id',
                    'loyaltypoints_id',
                ] as $column) {
                    $table->unsignedBigInteger($column)
                        ->nullable()
                        ->change();
                }
            }
        );
    }
};
