<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\Categories\Requests\CategorySiteSettingModuleValueRequest;
use Domain\Products\Models\Category\CategorySettingsSiteModuleValue;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategorySiteSettingModuleValue
{
    use AsObject;

    public function handle(
        CategorySiteSettingModuleValueRequest $request
    ) {
        CategorySettingsSiteModuleValue::updateOrCreate(
            [
                'site_id'=>$request->site_id,
                'category_id'=>$request->category_id,
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
