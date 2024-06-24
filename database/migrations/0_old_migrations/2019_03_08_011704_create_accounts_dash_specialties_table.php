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
        Schema::create('accounts-specialties', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->nullable()->index('parent_id');
            $table->string('name', 55);
            $table->integer('rank');
            $table->boolean('status');

            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-specialties');
    }
};
