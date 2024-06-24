<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\CategorySettingsTemplates\Requests\CategoryTemplateSettingModuleValueRequest;
use Domain\Products\Models\Category\CategorySettingsTemplateModuleValue;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategorySettingTemplateModuleValue
{
    use AsObject;

    public function handle(
        CategoryTemplateSettingModuleValueRequest $request
    ) {
        CategorySettingsTemplateModuleValue::updateOrCreate(
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
