<?php

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
        Schema::create('accounts_addtl_fields', function (Blueprint $table) {
            $table->integer('account_id')->index('aaf_account_id');
            $table->integer('form_id');
            $table->integer('section_id');
            $table->integer('field_id');
            $table->text('field_value');

            $table->unique(['account_id', 'form_id', 'section_id', 'field_id'], 'aaf_account_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_addtl_fields');
    }
};
