<?php

namespace Domain\Products\Actions;

use App\Api\Admin\Products\Requests\ProductSiteSettingModuleValueRequest;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductSiteSettingModuleValue
{
    use AsObject;

    public function handle(
        ProductSiteSettingModuleValueRequest $request
    ) {
        ProductSiteSettingsModuleValue::updateOrCreate(
            [
                'site_id'=>$request->site_id,
                'product_id'=>$request->product_id,
                'module_id'=>$request->module_id,
                'field_id'=>$request->field_id,
                'section_id'=>$request->section_id,

            ],
            [
                'custom_value' => $request->custom_value,
            ]
        );
    }
}
