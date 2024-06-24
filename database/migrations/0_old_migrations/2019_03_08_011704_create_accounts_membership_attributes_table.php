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
        Schema::create('accounts-membership-attributes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('rank');
            $table->text('details');
            $table->boolean('status');
            $table->integer('section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-membership-attributes');
    }
};
