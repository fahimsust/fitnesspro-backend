<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductSiteSettingsRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductSiteSettings
{
    use AsObject;

    public function handle(
        Product $product,
        ProductSiteSettingsRequest $request
    ): ProductSiteSettings {
        $product->siteSettings()->updateOrCreate(
            [
                'site_id' => $request->site_id,
            ],
            [
                'settings_template_id' => $request->settings_template_id_default == 1?$request->settings_template_id:null,
                'layout_id' => $request->layout_id_default == 1?$request->layout_id:null,
                'module_template_id' => $request->module_template_id_default == 1?$request->module_template_id:null,
                'product_detail_template' => $request->product_detail_template_default == 1?$request->product_detail_template:null,
                'product_thumbnail_template' => $request->product_thumbnail_template_default == 1?$request->product_thumbnail_template:null,
                'product_zoom_template' => $request->product_zoom_template_default == 1?$request->product_zoom_template:null,
                'settings_template_id_default' => $request->settings_template_id_default,
                'layout_id_default' => $request->layout_id_default,
                'module_template_id_default' => $request->module_template_id_default,
                'product_detail_template_default' => $request->product_detail_template_default,
                'product_thumbnail_template_default' => $request->product_thumbnail_template_default,
                'product_zoom_template_default' => $request->product_zoom_template_default,
            ]
        );
        return ProductSiteSettings::whereProductId($product->id)->whereSiteId($request->site_id)->first();
    }
}
