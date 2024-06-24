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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->string('domain', 65);
            $table->string('email', 85);
            $table->string('phone', 20);
            $table->string('url', 255);
            $table->boolean('status');
            $table->text('offline_message');
            $table->integer('offline_key');
            $table->string('meta_title', 255);
            $table->string('meta_keywords', 500);
            $table->string('meta_desc', 255);
            $table->bigInteger('account_type_id');
            $table->boolean('require_login')->comment('0=no, 1=for site, 2=for catalog');
            $table->string('required_account_types', 100);
            $table->string('version', 25);
            $table->string('template_set', 55);
            $table->bigInteger('theme_id');
            $table->boolean('apply_updates')->default(true);
            $table->string('logo_url',255);

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
};
