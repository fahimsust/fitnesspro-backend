<?php

namespace Database\Seeders;

use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\ProductDetail;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends AbstractSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::isProduction())
            return;

        $this->call([
            SiteSeeder::class,
            SpecialtySeeder::class,
            MessageTemplateSeeder::class,
            CountryIsoSeeder::class,
            LayoutSeeder::class,
            LayoutSectionSeeder::class,
            DisplayTemplatesTypeSeeder::class,
            DisplayTemplatesSeeder::class,
            ThemesSeeder::class,
            AffiliateReferralStatusSeeder::class,



            FriendsUpdatesTypesSeeder::class,
            RegistryGenderSeeder::class,
            RegistryTypesSeeder::class,

            InventoryGatewaySeeder::class,
            InventoryGatewaysFieldsSeeder::class,

            LanguageSeeder::class,
            //MenuSeeder::class,
            ModuleTemplateSeeder::class,

            OrdersTransactionStatusSeeder::class,
            PaymentGatewaySeeder::class,
            PaymentMethodSeeder::class,
            ProductAvailabilitySeeder::class,

            ProductSortSeeder::class,
            ReportProductFieldSeeder::class,
            ReportTypeSeeder::class,

            ShippingGatewaySeeder::class,
            ShippingCarrierSeeder::class,
            ShippingMethodSeeder::class,
            ShippingPackageTypeSeeder::class,

            ModuleSeeder::class,
            //            ImageSeeder::class,
            DistributorSeeder::class,
            //ProductSeeder::class,
            //ProductDetailSeeder::class,

            CountrySeeder::class,
            CountryRegionSeeder::class,
            StateSeeder::class,
            PricingRuleSeeder::class,
            //seed products
            //seed modules
            AccountMembershipLevelSeeder::class,
            //            AccountMessageKeySeeder::class,
            AccountStatusSeeder::class,
            AccountTypeSeeder::class, //update data in this seeder
            AffiliateSeeder::class,
            ReferralSeeder::class,
            AttributeTypeSeeder::class,
            AttributeSeeder::class,
            AttributeOptionSeeder::class,
            CurrencySeeder::class,
            //            OrderMessageKeySeeder::class,
            ShipmentStatusSeeder::class,
            PhotoAlbumTypeSeeder::class,
            ResortSeeder::class,

            SiteMessageTemplateSeeder::class,
            PricingRuleLevelSeeder::class,
            OrderingRuleSeeder::class,
            FulfillmentRuleSeeder::class,
            CatalogSeeder::class,
            AccountSeeder::class,
            ContentSeeder::class,
            CustomerSeeder::class,
            DiscountSeeder::class,
            AdminEmailSentSeeder::class,
            MessageTemplateCategorySeeder::class,
            OrderCustomFormSeeder::class,
            FaqSeeder::class,
            FaqCategorySeeder::class,
        ]);
    }
}
