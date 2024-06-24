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
        Schema::create('giftregistry', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('gi_account_id');
            $table->string('registry_name', 100);
            $table->tinyInteger('registry_type');
            $table->string('event_name', 100);
            $table->dateTime('event_date');
            $table->boolean('public_private');
            $table->string('private_key', 55);
            $table->dateTime('created');
            $table->dateTime('modified');
            $table->boolean('status')->default(1);
            $table->integer('shipto_id');
            $table->text('notes_to_friends');
            $table->string('registrant_name', 155);
            $table->string('coregistrant_name', 155);
            $table->date('baby_duedate');
            $table->boolean('baby_gender')->comment('0=male;1=female');
            $table->char('baby_name', 85);
            $table->boolean('baby_firstchild');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giftregistry');
    }
};
