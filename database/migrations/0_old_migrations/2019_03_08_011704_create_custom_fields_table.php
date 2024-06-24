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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('display');
            $table->string('name');
            $table->tinyInteger('type')->comment('0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button');
            $table->boolean('required')->default(1);
            $table->integer('rank');
            $table->string('cssclass', 100);
            $table->text('options');
            $table->text('specs');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_fields');
    }
};
