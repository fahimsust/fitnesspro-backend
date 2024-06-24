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
        Schema::create('products-rules-ordering_conditions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rule_id')->index('prruorco_rule_id');
            $table->enum('type', ['required_account', 'required_account_type', 'required_account_specialty'])->index('prruorco_type');
            $table->boolean('status')->index('prruorco_status');
            $table->enum('any_all', ['all', 'any']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-ordering_conditions');
    }
};
