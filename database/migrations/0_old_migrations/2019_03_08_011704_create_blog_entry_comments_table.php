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
        Schema::create('blog_entry_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entry_id')->index('blec_entry_id');
            $table->text('body');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->boolean('beenread')->default(0);
            $table->string('name', 55);
            $table->string('webaddress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_entry_comments');
    }
};
