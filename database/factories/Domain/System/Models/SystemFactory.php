<?php

namespace Database\Factories\Domain\System\Models;

use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\System\Models\System;
use Illuminate\Database\Eloquent\Factories\Factory;

class SystemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = System::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pendingStatus = ShipmentStatus::factory()->create(['name' => "Pending"]);

        return [
            'path' => '',
            'use_cim' => $this->faker->boolean,
            'charge_action' => 1,
            'split_charges_by_shipment' => false,
            'auto_archive_completed' => true,
            'auto_archive_canceled' => true,
            'use_fedex' => true,
            'use_ups' => true,
            'use_usps' => true,
            'catalog_img_url' => '//domain.com',
            'system_admin_url' => 'https://domain.com/admin',
            'system_name' => __('AdVision eCommerce'),
            'version' => config('app.version'),
            'version_updated' => $this->faker->dateTime(),
            'master_account_pass' => '',
            'is_admin_secure' => true,
            'system_admin_cookie' => '',
            'smtp_use' => true,
            'smtp_host' => '',
            'smtp_auth' => true,
            'smtp_secure' => 0,
            'smtp_port' => '',
            'smtp_username' => '',
            'smtp_password' => '',
            'cart_expiration' => 30,
            'cart_removestatus' => '',
            'cart_updateprices' => true,
            'cart_savediscounts' => false,
            'feature_toggle' => '',
            'check_for_shipped' => true,
            'check_for_delivered' => true,
            'validate_addresses' => false,
            'giftcard_template_id' => 0,
            'giftcard_waccount_template_id' => 0,
            'packingslip_showinternalnotes' => false,
            'packingslip_showavail' => false,
            'packingslip_showshipmethod' => false,
            'packingslip_showbillingaddress' => false,
            'ordersummaryemail_showavail' => false,
            'require_agreetoterms' => true,
            'profile_description' => '',
            'timezone' => 'UTC',
            'addtocart_external_label' => 'Order from Affiliate',
            'orderplaced_defaultstatus' => [
                "default" => $pendingStatus->id,
                "label" => ShipmentStatus::factory()->create(['name' => "Create Label"])->id,
                "download" => $pendingStatus->id,
                "dropship" => ShipmentStatus::factory()->create(['name' => "Drop Shipped"])->id,
                "unpaid" => ShipmentStatus::factory()->create(['name' => "Unpaid"])->id,
            ],
        ];
    }
}
