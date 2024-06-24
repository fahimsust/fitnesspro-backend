<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table(
            \Domain\Accounts\Models\Account::Table(),
            function (Blueprint $table) {
                $table->renameColumn('account_email', 'email');

                $table->renameColumn('account_pass', 'password');

                $table->renameColumn('account_user', 'username');

                $table->renameColumn('account_phone', 'phone');
                $table->renameColumn('account_created', 'created_at');
                $table->timestamp('updated_at')
                    ->useCurrentOnUpdate()
                    ->nullable();
                $table->renameColumn('account_lastlogin', 'lastlogin_at');

                $table->renameColumn('account_status_id', 'status_id');
                $table->renameColumn('account_type_id', 'type_id');

                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
            }
        );

        Schema::table(
            \Domain\Accounts\Models\Account::Table(),
            function (Blueprint $table) {
                $table->string('password', 255)->change();
            }
        );
    }

    public function down()
    {
        Schema::table(
            \Domain\Accounts\Models\Account::Table(),
            function (Blueprint $table) {
                $table->renameColumn('email', 'account_email');
                $table->renameColumn('password', 'account_pass');
                $table->renameColumn('username', 'account_user');

                $table->renameColumn('phone', 'account_phone');
                $table->renameColumn('created_at', 'account_created');
                $table->dropColumn('updated_at');
                $table->renameColumn('lastlogin_at', 'account_lastlogin');

                $table->renameColumn('status_id', 'account_status_id');
                $table->renameColumn('type_id', 'account_type_id');

                $table->dropColumn('email_verified_at');
                $table->dropColumn('remember_token');
                $table->string('password', 35)->change();
            }
        );
    }
};
