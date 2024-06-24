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
        Schema::table('accounts_cims', function (Blueprint $table) {
            $table->integer('account_id')->nullable()->change();
        });
        Schema::table('accounts_messages', function (Blueprint $table) {
            $table->integer('to_id')->nullable()->change();
            $table->integer('replied_id')->nullable()->change();
            $table->integer('from_id')->nullable()->change();
            $table->dateTime('readdate')->nullable()->change();
            $table->dateTime('sent')->nullable()->change();
        });
        Schema::table('discount', function (Blueprint $table) {
            $table->dateTime('exp_date')->nullable()->change();
            $table->dateTime('start_date')->nullable()->change();
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->dateTime('exp_date')->nullable()->change();
            $table->dateTime('start_date')->nullable()->change();
        });
        Schema::table('friends', function (Blueprint $table) {
            $table->dateTime('added')->nullable()->change();
        });
        Schema::table('mods_account_certifications', function (Blueprint $table) {
            $table->dateTime('created')->nullable()->change();
            $table->dateTime('updated')->nullable()->change();
        });
        Schema::table('mods_account_certifications_files', function (Blueprint $table) {
            $table->dateTime('uploaded')->nullable()->change();
        });
        Schema::table('orders_customforms', function (Blueprint $table) {
            $table->dateTime('modified')->nullable()->change();
        });
        Schema::table('orders_shipments', function (Blueprint $table) {
            $table->dateTime('ship_date')->nullable()->change();
            $table->dateTime('future_ship_date')->nullable()->change();
            $table->dateTime('delivery_date')->nullable()->change();
            $table->dateTime('last_status_update')->nullable()->change();
        });
        Schema::table('orders_transactions', function (Blueprint $table) {
            $table->dateTime('updated')->nullable()->change();
            $table->dateTime('voided_date')->nullable()->change();
            $table->date('cc_exp')->nullable()->change();
        });
        Schema::table('photos_albums', function (Blueprint $table) {
            $table->dateTime('updated')->nullable()->change();
        });
        Schema::table('products_details', function (Blueprint $table) {
            $table->dateTime('orders_updated')->nullable()->change();
            $table->dateTime('views_updated')->nullable()->change();
        });
        Schema::table('products_options_values', function (Blueprint $table) {
            $table->dateTime('start_date')->nullable()->change();
            $table->dateTime('end_date')->nullable()->change();
        });
        Schema::table('products_pricing', function (Blueprint $table) {
            $table->dateTime('published_date')->nullable()->change();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->dateTime('from_date')->nullable()->change();
            $table->dateTime('to_date')->nullable()->change();
            $table->dateTime('modified')->nullable()->change();
        });
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dateTime('created')->nullable()->change();
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->dateTime('account_created')->nullable()->change();
            $table->dateTime('account_lastlogin')->nullable()->change();
            $table->date('last_verify_attempt_date')->nullable()->change();
        });
        Schema::table('accounts_memberships', function (Blueprint $table) {
            $table->dateTime('cancelled')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
