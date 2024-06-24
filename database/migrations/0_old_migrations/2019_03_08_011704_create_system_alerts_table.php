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
        Schema::create('system_alerts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->tinyInteger('reference_type')->comment('0 = other, 1 = order, 2 = transaction, 3 = shipment, 4 = package, 5 = account, 6 = product');
            $table->integer('reference_id')->index('reference_id');
            $table->text('description');
            $table->dateTime('created');
            $table->boolean('been_read');
            $table->dateTime('read_on');
            $table->index(['reference_type', 'reference_id'], 'reference_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_alerts');
    }
};
