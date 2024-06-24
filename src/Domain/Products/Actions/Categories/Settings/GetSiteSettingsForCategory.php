<?php

namespace Domain\Products\Actions\Categories\Settings;

use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class GetSiteSettingsForCategory
{
    use AsObject;

    public function handle(
        Category $category,
    ): array {
        $siteSettings = $category->siteSettings;
        $sites = Site::all();
        $categorySiteSettings = [];
        $default = $siteSettings->first(function($item) {
            return $item->site_id == null;
        });
        if(!$default)
        {
            $default['setting_template_id'] = null;
        }
        $categorySiteSettings[] = ['site_id'=>null,'name'=>'Default','settings'=>$default];
        foreach($sites as $value)
        {
            $siteSetting = $siteSettings->first(function($item) use ($value) {
                return $item->site_id == $value->id;
            });
            if(!$siteSetting)
            {
                $siteSetting['setting_template_id'] = null;
            }
            $categorySiteSettings[] = ['site_id'=>$value->id,'name'=>$value->name,'settings'=>$siteSetting];

        };
        return $categorySiteSettings;
    }
}
