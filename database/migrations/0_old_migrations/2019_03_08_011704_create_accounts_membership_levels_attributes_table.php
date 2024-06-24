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
        Schema::create('accounts-membership-levels_attributes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('level_id');
            $table->integer('attribute_id');
            $table->string('attribute_value');
            $table->unique(['level_id', 'attribute_id'], 'level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-membership-levels_attributes');
    }
};
