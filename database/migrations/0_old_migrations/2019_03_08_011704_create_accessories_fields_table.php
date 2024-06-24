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
        Schema::create('accessories_fields', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('label', 100);
            $table->boolean('field_type')->default(1)->comment('1=select menu, 2=radio options, 3=checkboxes');
            $table->boolean('required');
            $table->string('select_display', 65)->comment('select menu default display before option is selected');
            $table->boolean('select_auto')->comment('should the first option be auto selected');
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
        Schema::dropIfExists('accessories_fields');
    }
};
