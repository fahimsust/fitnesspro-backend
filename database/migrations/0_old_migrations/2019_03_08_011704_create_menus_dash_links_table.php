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
        Schema::create('menus-links', function (Blueprint $table) {
            $table->integer('id', true);
            $table->boolean('link_type')->comment('1=url, 2=system, 3=javascript');
            $table->string('label', 155);
            $table->enum('target', ['_blank', '_self', '_parent', '_top']);
            $table->text('url_link');
            $table->integer('system_link')->comment('1=home, 2=contact, 3=myaccount, 4=cart, 5=checkout, 6=wishlist');
            $table->text('javascript_link');
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus-links');
    }
};
