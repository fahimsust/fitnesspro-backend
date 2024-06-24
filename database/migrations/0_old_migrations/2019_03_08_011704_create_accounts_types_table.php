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
        Schema::create('accounts-types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->tinyInteger('default_account_status');
            $table->integer('custom_form_id');
            $table->integer('email_template_id_creation_admin');
            $table->integer('email_template_id_creation_user');
            $table->integer('email_template_id_activate_user');
            $table->integer('discount_level_id');
            $table->tinyInteger('verify_user_email')->default(0);
            $table->boolean('filter_products')->comment('0=no, 1=show select, 2= hide selected');
            $table->boolean('filter_categories')->comment('0=no, 1=show select, 2= hide selected');
            $table->integer('loyaltypoints_id');
            $table->boolean('use_specialties');
            $table->integer('membership_level_id');
            $table->integer('email_template_id_verify_email');
            $table->integer('affiliate_level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-types');
    }
};
