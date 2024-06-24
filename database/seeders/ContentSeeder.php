<?php
namespace Database\Seeders;

use Domain\Content\Models\Element;
use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageTranslation;
use Domain\Locales\Models\Language;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentGateway;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Domain\Sites\Models\SiteSettings;

class ContentSeeder extends AbstractSeeder
{
    public function run()
    {
        $pages = Page::factory(100)->create();
        $gateWays = PaymentGateway::all();
        foreach($gateWays as $value)
        {
            PaymentAccount::factory(rand(1,3))->create(['gateway_id'=>$value->id]);
        }
        Element::factory(100)->create();
        $languages = Language::all();
        $sites = Site::all();
        foreach($sites as $site)
        {
            foreach($languages as $language)
            {
                SiteLanguage::factory()->create([
                    'site_id'=>$site->id,
                    'language_id'=>$language->id
                ]);
            }
            SiteSettings::factory()->create(['site_id'=>$site->id]);
        }
        foreach($pages as $page)
        {
            foreach($languages as $language)
            {
                if(rand(0,1)==1)
                {
                    PageTranslation::factory()->create([
                        'page_id'=>$page->id,
                        'language_id'=>$language->id
                    ]);
                }
            }
        }
    }
}
