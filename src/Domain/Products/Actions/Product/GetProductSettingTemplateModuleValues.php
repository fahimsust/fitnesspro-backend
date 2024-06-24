<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductTemplateSettingModuleValueSearchRequest;
use Domain\Modules\Actions\GetModuleFieldOptions;
use Domain\Modules\Models\Module;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductSettingTemplateModuleValues
{
    use AsObject;

    public function handle(
        ProductTemplateSettingModuleValueSearchRequest $request
    ) {
        $fields = [];
        $module = Module::whereId($request->module_id)->first();
        $productSettingsTemplateModuleValue = $module->productSettingsTemplateModuleValue()
        ->where('settings_template_id', $request->settings_template_id)
        ->where('section_id', $request->section_id)->get();
        $fieldModules = $module->fields()
        ->orderBy('id')->get();

        if ($fieldModules) {
            foreach ($fieldModules as $field) {
                $custom_value = "";

                if ($productSettingsTemplateModuleValue) {

                    $field_value = $productSettingsTemplateModuleValue
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
