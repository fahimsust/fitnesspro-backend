<?php

namespace Database\Seeders;

use Domain\Modules\Models\ModuleSiteController;
use Illuminate\Database\Seeder;

class ModuleSiteControllerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,49,'customer_account_settings',1,'Account Files','settings/account_files','account_files'],
            [2,50,'customer_account_settings',1,'Certifications','settings/account_certifications','account_certifications'],
            [3,45,'customer_account_networking',1,'Activities','networking/friend_activities','friend_activities'],
            [4,63,'customer_account_networking',1,'Advertising','networking/account_ads','account_ads'],
            [5,69,'customer_account_orders',0,'Travel Vouchers','orders/fitpro_travelvoucher','fitpro_travelvoucher'],
            [6,69,'customer_account_settings',1,'Trip Flyers','settings/fitpro_travelvoucher','fitpro_travelvoucher'],
            [7,75,'account_creation',0,'accountcreation_myemmasubscribe','signup/payment/accountcreation_myemmasubscribe','accountcreation_myemmasubscribe']
        ];
        $fields = ['id','module_id','controller_section','showinmenu','menu_label','menu_link','url_name'];

        foreach ($rows as $row) {
            ModuleSiteController::create(array_combine($fields, $row));
        }
    }
}
