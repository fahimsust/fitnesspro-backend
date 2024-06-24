<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;

class GetSiteSettingsForProduct
{
    use AsObject;

    public function handle(
        Product $product,
    ): array {
        $productSetting = $product->load(['siteSettings'=>['moduleTemplate','settingsTemplate','layout','zoomTemplate','detailTemplate','thumbnailTemplate']]);
        $sites = Site::all();
        $productSiteSettings = [];
        $default = $productSetting->siteSettings->first(function($item) {
            return $item->site_id == null;
        });
        $productSiteSettings[] = ['site_id'=>null,'name'=>null,'settings'=>$default];
        foreach($sites as $value)
        {
            $siteSetting = $productSetting->siteSettings->first(function($item) use ($value) {
                return $item->site_id == $value->id;
            });
            $productSiteSettings[] = ['site_id'=>$value->id,'name'=>$value->name,'settings'=>$siteSetting];

        };
        return $productSiteSettings;
    }
}
