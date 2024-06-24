<?php

namespace Tests\Feature\Traits;

use Database\Seeders\AccountMembershipLevelSeeder;
use Database\Seeders\AccountStatusSeeder;
use Database\Seeders\AccountTypeSeeder;
use Database\Seeders\AffiliateReferralStatusSeeder;
use Database\Seeders\MessageTemplateSeeder;
use Database\Seeders\PaymentGatewaySeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\ProductAvailabilitySeeder;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Facades\DB;

trait MembershipJobData
{

    public function seedMembershipData()
    {
        if (in_array(app()->environment(), ["local", "testing"])) {
            $this->seed([
                ProductAvailabilitySeeder::class,
                MessageTemplateSeeder::class,
                PaymentGatewaySeeder::class,
                PaymentMethodSeeder::class,
            ]);

            if (\Domain\Affiliates\Models\ReferralStatus::count() == 0) {
                (new AffiliateReferralStatusSeeder)->run();
            }

            if (!MembershipLevel::find(4))
                (new AccountMembershipLevelSeeder)->run();

//            $table = \App\Models\Account\Membership\AccountMembershipLevel::table();
//            DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = 5");

            if (!\Domain\Accounts\Models\AccountStatus::find(6))
                (new AccountStatusSeeder)->run();

//            $table = AccountStatus::table();
//            DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = 7");

            if (!AccountType::find(1))
                (new AccountTypeSeeder)->run();
//            $table = AccountType::table();
//            DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = 2");
        }

//    create discount levels
        DB::statement('INSERT INTO `discounts_levels` (`id`, `name`, `apply_to`, `action_percentage`, `action_sitepricing`, `status`)
SELECT 3, "Enterprise Auto 7%", apply_to, 7, action_sitepricing, status FROM `discounts_levels` WHERE id = 1');//id = 3

        DB::statement('INSERT INTO `discounts_levels_products` (`discount_level_id`, `product_id`)
SELECT 3, product_id FROM `discounts_levels_products` WHERE discount_level_id = 1');

        DB::statement('INSERT INTO `discounts_levels` (`id`, `name`, `apply_to`, `action_percentage`, `action_sitepricing`, `status`)
SELECT 4, "Medallion Auto 7%", apply_to, 7, action_sitepricing, status FROM `discounts_levels` WHERE id = 2');//id = 4

        DB::statement('INSERT INTO `discounts_levels_products` (`discount_level_id`, `product_id`)
SELECT 4, product_id FROM `discounts_levels_products` WHERE discount_level_id = 2');

        $this->createMembershipLevel(
            'Basic 30-day Trial',
            'basic',
            [
                'trial' => true,
                'affiliate_level_id' => 1,
                'signuprenew_option' => 0,
                'signupemail_customer' => null,
                'renewemail_customer' => null,
                'expirationalert1_email' => null,
                'expirationalert2_email' => null,
                'expiration_email' => null,
            ],
            [
                'affiliate_level_id' => 1,
                'email_template_id_creation_user' => 0,
                'email_template_id_creation_admin' => 0,
                'email_template_id_activate_user' => 0,
            ]
        );

        $this->createMembershipLevel(
            'Basic - Auto Renew',
            'basic',
            [
                'auto_renewal_of' => 1,
                'auto_renew_reward' => 25,
                'affiliate_level_id' => 1,
                'signupemail_customer' => null,
                'renewemail_customer' => null,
                'expirationalert1_email' => null,
                'expirationalert2_email' => null,
                'expiration_email' => null,
            ],
            [
                'affiliate_level_id' => 1,
                'email_template_id_creation_user' => 0,
            ]
        );

        $this->createMembershipLevel(
            'Travel - Auto Renew',
            'travel',
            [
                'auto_renewal_of' => 2,
                'auto_renew_reward' => 500,
                'affiliate_level_id' => 2,
                'signupemail_customer' => null,
                'renewemail_customer' => null,
                'expirationalert1_email' => null,
                'expirationalert2_email' => null,
                'expiration_email' => null,
            ],
            [
                'affiliate_level_id' => 2,
                'email_template_id_creation_user' => 0,
            ]
        );

        $this->createMembershipLevel(
            'Medallion - Auto Renew',
            'medallion',
            [
                'auto_renewal_of' => 3,
                'auto_renew_reward' => 2500,
                'affiliate_level_id' => 3,
                'signupemail_customer' => null,
                'renewemail_customer' => null,
                'expirationalert1_email' => null,
                'expirationalert2_email' => null,
                'expiration_email' => null,
            ],
            [
                'discount_level_id' => \Domain\Discounts\Models\Level\DiscountLevel::firstOrFactory(),
                'affiliate_level_id' => 3,
                'email_template_id_creation_user' => 0,
            ]
        );

        $this->createMembershipLevel(
            'Enterprise - Auto Renew',
            'enterprise',
            [
                'auto_renewal_of' => 4,
                'auto_renew_reward' => 7500,
                'affiliate_level_id' => 4,
                'signupemail_customer' => null,
                'renewemail_customer' => null,
                'expirationalert1_email' => null,
                'expirationalert2_email' => null,
                'expiration_email' => null,
            ],
            [
                'discount_level_id' => \Domain\Discounts\Models\Level\DiscountLevel::firstOrFactory(),
                'affiliate_level_id' => 4,
                'email_template_id_creation_user' => 0,
            ]
        );
    }


    private function createMembershipLevel(
        string $name,
        string $tag,
        array  $levelAttributes = [],
        array  $typeAttributes = [],
        float  $price = 0.00
    )
    {
        $title = $name . " Membership";

        if (Product::firstWhere(['title' => $title]) != null)
            return;

        $product = Product::factory([
            'title' => $title,
            'url_name' => \Illuminate\Support\Str::slug($title),
            'default_outofstockstatus_id' => 1,
            'default_distributor_id' => Distributor::firstOrFactory(),
            'meta_title' => $title,
            'meta_desc' => $title,
            'meta_keywords' => $title,
            'inventoried' => 0
        ])->create();

        ProductDetail::factory([
            'product_id' => $product->id,
            'summary' => $title,
            'description' => $title,
            'type_id' => ProductType::firstOrFactory(),
            'brand_id' => Brand::firstOrFactory(),
            'downloadable' => 1,
        ])->create();

        \Illuminate\Support\Facades\DB::table('products_pricing')
            ->insert([
                'product_id' => $product->id,
                'price_reg' => $price,
                'site_id' => null,
                'status' => 0,
            ]);

        \Illuminate\Support\Facades\DB::table('products_pricing')
            ->insert([
                'product_id' => $product->id,
                'price_reg' => $price,
                'site_id' => \Domain\Sites\Models\Site::firstOrFactory()->id,
                'status' => 1,
            ]);

        //setup auto renew membership levels
        $membershipLevel = MembershipLevel::factory([
                'name' => $name,
                'annual_product_id' => $product->id,
                'description' => '',
                'tag' => $tag,
            ] + $levelAttributes
        )->create();

        AccountType::factory([
                'name' => $name,
                'membership_level_id' => $membershipLevel->id,
                'default_account_status' => \Domain\Accounts\Enums\AccountStatus::ACTIVE,
                'custom_form_id' => \Domain\CustomForms\Models\CustomForm::firstOrFactory(),
                'use_specialties' => 1,
            ] + $typeAttributes)->create();
    }
}
