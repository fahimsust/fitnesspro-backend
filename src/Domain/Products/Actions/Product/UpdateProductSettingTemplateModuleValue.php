<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductTemplateSettingModuleValueRequest;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductSettingTemplateModuleValue
{
    use AsObject;

    public function handle(
        ProductTemplateSettingModuleValueRequest $request
    ) {
        ProductSettingsTemplateModuleValue::updateOrCreate(
            [
                'settings_template_id'=>$request->settings_template_id,
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
