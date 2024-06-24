<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Modules\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 'Related Products (By Brand)', 'related_products_bybrand', '', '', 0],
            [2, 'Product Specifications', 'product_specs', '', '', 0],
            [3, 'Customer Account Menu', 'customeraccount_menu', '{&quot;personalize_default&quot;:&quot;My &quot;}', '', 0],
            [4, 'Affiliate Account Menu', 'affiliateaccount_menu', '', '', 0],
            [5, 'Standard Zoom', 'product_zoom', '', '', 0],
            [10, 'Related Products (By Last Added to Cart)', 'related_products_bylastadded', '', '', 0],
            [11, 'Related Products (By Items in Cart)', 'related_products_bycart', '', '', 0],
            [12, 'Recently Viewed Products', 'recently_viewed_products', '', '', 0],
            [14, 'Checkout Steps', 'checkout_steps', '', '', 0],
            [17, 'Related Products', 'related_products', '', '', 0],
            [25, 'Cart Summary (Simple)', 'cart_summary_simple', '', '', 0],
            [26, 'Cart Summary (Advanced)', 'cart_summary_advanced', '', '', 0],
            [27, 'Brands Menu', 'brands_menu', '', '', 0],
            [28, 'Newsletter Signup', 'newsletter_signup', '', '', 0],
            [29, 'Simple Search', 'simple_search', '', '', 0],
            [31, 'Categories Menu', 'categories_menu', '', '', 0],
            [36, 'Product Reviews', 'product_reviews', '', '', 0],
            [37, 'Related Products - Manual', 'related_products_manual', '', '', 0],
            [38, 'Product Photos Display/Upload', 'product_photos', '{&quot;type&quot;:&quot;1&quot;,&quot;selected_attribute&quot;:&quot;21&quot;,&quot;show_for&quot;:&quot;1&quot;,&quot;show_for_types&quot;:&quot;1&quot;}', 'Photos for products', 0],
            [39, 'Account Order History', 'account_orderhistory', '', 'Display recent orders in account', 0],
            [40, 'Account Address List', 'account_addresses', '', 'Display short list of addresses in account', 0],
            [41, 'Account Gift Registries List', 'account_giftregistries', '', 'Display short list of gift registries in account', 0],
            [43, 'Account Missing Profile Image', 'account_missingprofileimage', '', 'Produce warning if account doesn\'t have a profile image', 0],
            [44, 'My Friends List', 'friend_myfriends', '', 'Display friends of an account', 0],
            [45, 'Friend Activities List', 'friend_activities', '', 'Display friend\'s activities', 0],
            [46, 'Networking Summary', 'account_networkingsummary', '', 'Show summary of different networking info', 0],
            [47, 'List Upcoming Events', 'account_upcomingevents', '', 'Display list of upcoming events', 0],
            [48, 'Networking Alerts', 'account_networkingalerts', '', 'Display alerts of networking activities', 0],
            [49, 'Account Files', 'account_files', '{&quot;show_in_customermenu&quot;:&quot;1&quot;,&quot;list_element_id&quot;:&quot;64&quot;}', '', 1],
            [50, 'Account Certifications', 'account_certifications', '{&quot;show_in_customermenu&quot;:&quot;1&quot;,&quot;list_element_id&quot;:&quot;65&quot;,&quot;edit_element_id&quot;:&quot;0&quot;}', '', 1],
            [51, 'Lookbooks v2', 'lookbookv2', '', 'Lookbook gallery modules.', 1],
            [52, 'Breadcrumbs', 'breadcrumbs', '', '', 0],
            [53, 'Search Vacations', 'fitpro_searchvacations', '', 'Search Form for Vacations', 0],
            [54, 'Search Form', 'search_form', '', 'Load a search form', 0],
            [55, 'Fitpro Book a Trip', 'fitpro_bookatrip', '{&quot;resort_attribute&quot;:&quot;21&quot;,&quot;country_attribute&quot;:&quot;1&quot;,&quot;teaching_vacation_type&quot;:&quot;1&quot;}', 'Book a trip mod for homepage', 0],
            [56, 'Custom Page Insert', 'custom_page_insert', '', 'Load custom page content via module', 0],
            [57, 'Custom Element Insert', 'custom_element_insert', '', 'Load custom element content via module', 0],
            [58, 'Account Start Register Form', 'account_startregister', '', 'Display fields to start registration for account', 0],
            [59, 'Account Remote Login Form', 'account_remotelogin', '', 'Display login form', 0],
            [60, 'Account Newest Registrations', 'account_newestregistrations', '', 'Display newest member registrations', 0],
            [61, 'Recently Ordered Products', 'products_recentlyordered', '', 'Display list of recently ordered items', 0],
            [62, 'Upcoming Events', 'events_upcoming', '', 'Display list of feature events', 0],
            [63, 'Account Ads', 'account_ads', '{&quot;show_in_customermenu&quot;:&quot;1&quot;,&quot;list_element_id&quot;:&quot;63&quot;,&quot;add_element_id&quot;:&quot;0&quot;,&quot;edit_element_id&quot;:&quot;0&quot;}', '', 1],
            [64, 'Page Menus', 'page_menus', '', 'Load multiple page menus', 0],
            [65, 'Advanced Categories Menu', 'categories_advancedmenu', '', '', 0],
            [66, 'Resort Details', 'fitpro_resortdetails', '{&quot;resort_attribute&quot;:&quot;21&quot;,&quot;airport_attribute&quot;:&quot;23&quot;,&quot;region_attribute&quot;:&quot;22&quot;,&quot;type_attribute&quot;:&quot;18&quot;,&quot;element_id&quot;:&quot;&quot;,&quot;campaign_id&quot;:&quot;1&quot;}', 'Resort specific details for the resort details page', 1],
            [67, 'Resort Details Link', 'fitpro_resortdetailslink', '{&quot;resort_attribute&quot;:&quot;21&quot;,&quot;resort_category_id&quot;:&quot;67&quot;}', 'The link shown on products page to forward user to resort details page', 0],
            [68, 'Account Search Profiles Form', 'account_searchprofiles', '', 'Display fields to search profiles', 0],
            [69, 'Travel Vouchers', 'fitpro_travelvoucher', '{&quot;travel_producttype_id&quot;:&quot;1&quot;}', 'Vouchers for travel on fitpro', 0],
            [70, 'Magic Zoom v2', 'product_magiczoomv2', '', 'Magic zoom for product details page.', 0],
            [71, 'Override Required Login for Catalog', 'catalog_requirelogin_override', '', '', 0],
            [72, 'Fitpro Upcoming/Post Trip Notification', 'fitpro_upcomingtrip', '{&quot;resort_attribute&quot;:&quot;21&quot;,&quot;teaching_vacation_type&quot;:&quot;1&quot;,&quot;upcoming_trip_msgtemplate_id&quot;:&quot;121&quot;,&quot;early_upcoming_trip_msgtemplate_id&quot;:&quot;181&quot;,&quot;post_trip_msgtemplate_id&quot;:&quot;72&quot;,&quot;arrived_at_trip_msgtemplate_id&quot;:&quot;190&quot;}', 'Upcoming and post trip notifications', 0],
            [73, 'Auto Update Dates Order Rules', 'fitpro_datesautoorderrules', '', 'Auto change order rules when start date within certain days', 1],
            [74, 'FAQ Top List', 'faq_toplist', '', 'List top number of FAQs', 0],
            [75, 'Account Creation Myemma', 'accountcreation_myemmasubscribe', '{&quot;account_id&quot;:&quot;40748&quot;,&quot;public_api_key&quot;:&quot;340915c2325257b6af9d&quot;,&quot;private_api_key&quot;:&quot;3a4261ad1b03776e4e4f&quot;,&quot;type&quot;:&quot;0&quot;}', '', 1],
            [76, 'Category Slider', 'fitpro_categoryslider', '{&quot;resort_attribute&quot;:&quot;21&quot;,&quot;airport_attribute&quot;:&quot;23&quot;,&quot;region_attribute&quot;:&quot;22&quot;,&quot;type_attribute&quot;:&quot;18&quot;,&quot;category_id&quot;:&quot;159&quot;}', '', 0],
            [77, 'Cookie Policy Warning', 'cookie_policy', '{&quot;privacypolicy_link&quot;:&quot;/privacy-policy&quot;,&quot;termsofuse_link&quot;:&quot;/terms-and-conditions&quot;,&quot;cookiepolicy_link&quot;:&quot;/cookie-policy&quot;,&quot;bg_color&quot;:&quot;rgba(255,255,255,0.9)&quot;,&quot;text_color&quot;:&quot;#666&quot;}', '', 0],
            [78, 'Facebook Sharing Meta Data', 'facebook_metadata', '', '', 0]
        ];
        $fields = ['id', 'name', 'file', 'config_values', 'description', 'showinmenu'];

        foreach ($rows as $row) {
            Module::create(array_combine($fields, $row));
        }
    }
}
