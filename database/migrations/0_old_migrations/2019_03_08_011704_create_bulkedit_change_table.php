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
        Schema::create('bulkedit_change', function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('created');
            $table->string('action_type', 10);
            $table->text('action_changeto');
            $table->integer('products_edited');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulkedit_change');
    }
};
