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
        Schema::create('search_forms_fields', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('display');
            $table->tinyInteger('type')->comment('0=text, 1=textarea, 2=checkbox, 3=radio, 4=select, 5=selectmultiple, 6=button');
            $table->boolean('search_type')->comment('0=attribute, 1=producttype, 2=membershiplevel');
            $table->integer('search_id');
            $table->integer('rank');
            $table->string('cssclass', 100);
            $table->boolean('status');
            $table->integer('help_element_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_forms_fields');
    }
};
