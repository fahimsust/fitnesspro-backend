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
        Schema::create('accounts_message_keys', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
            $table->string('key_id', 55);
            $table->string('key_var', 55);
            $table->primary('key_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_message_keys');
    }
};
