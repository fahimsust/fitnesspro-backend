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
        Schema::create('mods_resort_details', function (Blueprint $table) {
            $table->integer('attribute_option_id')->primary();
            $table->text('description');
            $table->text('comments');
            $table->string('logo', 80)->default('');
            $table->string('fax', 20)->default('');
            $table->string('contact_addr', 80)->default('');
            $table->string('contact_city', 35)->default('');
            $table->integer('contact_state_id');
            $table->string('contact_zip', 20)->default('');
            $table->integer('contact_country_id');
            $table->string('mgr_lname', 35)->default('');
            $table->string('mgr_fname', 35)->default('');
            $table->string('mgr_phone', 20)->default('');
            $table->string('mgr_email', 65)->default('');
            $table->string('mgr_fax', 20)->default('');
            $table->text('notes');
            $table->text('transfer_info');
            $table->string('url_name', 200);
            $table->binary('details')->nullable();
            $table->text('schedule_info');
            $table->text('suz_comments');
            $table->string('link_resort');
            $table->string('concierge_name', 65);
            $table->string('concierge_email', 85);
            $table->string('facebook_fanpage');
            $table->text('giftfund_info');
            $table->tinyInteger('resort_type');
            $table->integer('region_id');
            $table->integer('airport_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_resort_details');
    }
};
