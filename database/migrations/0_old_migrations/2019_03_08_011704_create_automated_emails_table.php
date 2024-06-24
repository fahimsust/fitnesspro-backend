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
        Schema::create('automated_emails', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->integer('message_template_id')->index('message_template_id');
            $table->boolean('status');
            $table->tinyInteger('send_on')->comment('0=status change, 1=days after order, 2=days after shipped, 3= days after delivered');
            $table->integer('send_on_status');
            $table->integer('send_on_daysafter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automated_emails');
    }
};
