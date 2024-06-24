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
        Schema::create('admin_emails_sent', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('adems_account_id');
            $table->integer('template_id');
            $table->string('sent_to', 85);
            $table->string('subject');
            $table->text('content');
            $table->dateTime('sent_date');
            $table->integer('sent_by');
            $table->integer('order_id')->index('adems_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_emails_sent');
    }
};
