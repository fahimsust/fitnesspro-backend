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
        Schema::create('distributors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->boolean('active')->default(1);
            $table->string('email', 85);
            $table->string('phone', 15);
            $table->string('account_no', 35);
            $table->boolean('is_dropshipper');
            $table->integer('inventory_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors');
    }
};
