<?php

use Domain\Accounts\Models\AccountSpecialty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create(AccountSpecialty::Table(), function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('acsp_account_id');
            $table->integer('specialty_id');
            $table->boolean('approved');
            $table->unique(['account_id', 'specialty_id'], 'acsp_account_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(AccountSpecialty::Table());
    }
};
