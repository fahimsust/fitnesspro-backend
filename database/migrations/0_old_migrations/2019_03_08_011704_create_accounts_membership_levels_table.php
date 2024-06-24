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
        Schema::create('accounts-membership-levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->integer('rank');
            $table->boolean('status');
            $table->integer('annual_product_id');
            $table->integer('monthly_product_id');
            $table->decimal('renewal_discount', 5);
            $table->text('description');
            $table->integer('signupemail_customer');
            $table->integer('renewemail_customer');
            $table->integer('expirationalert1_email');
            $table->integer('expirationalert2_email');
            $table->integer('expiration_email');
            $table->integer('affiliate_level_id');
            $table->boolean('is_default');
            $table->boolean('signuprenew_option')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-membership-levels');
    }
};
