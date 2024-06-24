<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\CategorySettingsTemplates\Requests\SettingModuleValueSearchRequest;
use Domain\Modules\Actions\GetModuleFieldOptions;
use Domain\Modules\Models\Module;
use Lorisleiva\Actions\Concerns\AsObject;

class GetCategorySettingTemplateModuleValues
{
    use AsObject;

    public function handle(
        SettingModuleValueSearchRequest $request
    ) {
        $fields = [];
        $module = Module::whereId($request->module_id)->first();
        $categorySettingsTemplateModuleValue = $module->categorySettingsTemplateModuleValue()
        ->where('settings_template_id', $request->settings_template_id)
        ->where('section_id', $request->section_id)->get();
        $fieldModules = $module->fields()
        ->orderBy('id')->get();

        if ($fieldModules) {
            foreach ($fieldModules as $field) {
                $custom_value = "";

                if ($categorySettingsTemplateModuleValue) {

                    $field_value = $categorySettingsTemplateModuleValue
                        ->firstWhere('field_id', $field->id);

                    if ($field_value) {
                        $custom_value = $field_value->custom_value;
                    }
                }
                $fields[] = ['field' => $field,'field_setting'=>GetModuleFieldOptions::run($field), 'custom_value' => $custom_value];
            }
        }

        return $fields;
    }
}
