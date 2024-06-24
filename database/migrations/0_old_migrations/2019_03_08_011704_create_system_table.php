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
        Schema::create('system', function (Blueprint $table) {
            $table->integer('id')->default(1)->primary();
            $table->string('path');
            $table->boolean('use_cim');
            $table->tinyInteger('charge_action')->default(1)->comment('1 = auth & capture, 2 = auth only');
            $table->boolean('split_charges_by_shipment');
            $table->boolean('auto_archive_completed');
            $table->boolean('auto_archive_canceled');
            $table->boolean('use_fedex');
            $table->boolean('use_ups');
            $table->boolean('use_usps');
            $table->string('catalog_img_url', 155)->default('//domain.com/');
            $table->string('system_admin_url', 155)->default('https://domain.com/admin/');
            $table->string('system_name', 55)->default('Advision Ecommerce');
            $table->string('version', 20)->default('1.0.0');
            $table->dateTime('version_updated');
            $table->string('master_account_pass', 85);
            $table->boolean('is_admin_secure');
            $table->string('system_admin_cookie', 85);
            $table->boolean('smtp_use');
            $table->string('smtp_host', 85);
            $table->boolean('smtp_auth'); //show authenticate

            /*
            $secures->addResult(array("value"=>0, "display"=>"None"));
            $secures->addResult(array("value"=>1, "display"=>"SSL"));
            $secures->addResult(array("value"=>2, "display"=>"TLS"));
            */
            $table->tinyInteger('smtp_secure');

            $table->string('smtp_port', 6);
            $table->string('smtp_username', 85);
            $table->string('smtp_password', 55);
            $table->integer('cart_expiration')->default(30)->comment('number of days before cookie expires');
            $table->string('cart_removestatus', 100);
            $table->boolean('cart_updateprices')->default(1);
            $table->boolean('cart_savediscounts')->default(1);
            $table->text('feature_toggle');
            $table->boolean('check_for_shipped');
            $table->boolean('check_for_delivered');
            $table->string('orderplaced_defaultstatus')->default('{\"default\":1, \"label\":2, \"download\":1, \"dropship\":4, \"unpaid\":9}');
            $table->string('validate_addresses', 20)->comment('0=no validation; >0=distributor.carrier_id to validate with');
            $table->integer('giftcard_template_id');
            $table->integer('giftcard_waccount_template_id');
            $table->boolean('packingslip_showinternalnotes');
            $table->boolean('packingslip_showavail');
            $table->boolean('packingslip_showshipmethod');
            $table->boolean('packingslip_showbillingaddress');
            $table->boolean('ordersummaryemail_showavail');
            $table->boolean('require_agreetoterms');
            $table->text('profile_description');
            $table->string('timezone', 155)->default('UTC');
            $table->string('addtocart_external_label')->default('Order from Affiliate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system');
    }
};
