<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\Categories\Requests\CategorySiteSettingModuleValueSearchRequest;
use Domain\Modules\Actions\GetModuleFieldOptions;
use Domain\Modules\Models\Module;
use Lorisleiva\Actions\Concerns\AsObject;

class GetCategorySiteSettingModuleValues
{
    use AsObject;

    public function handle(
        CategorySiteSettingModuleValueSearchRequest $request
    ) {
        $fields = [];
        $module = Module::whereId($request->module_id)->first();
        $categorySettingsSiteModuleValue = $module->categorySettingsSiteModuleValue()
        ->where('category_id', $request->category_id)
        ->where('site_id', $request->site_id)
        ->where('section_id', $request->section_id)->get();
        $fieldModules = $module->fields()
        ->orderBy('id')->get();
        if ($fieldModules) {
            foreach ($fieldModules as $field) {
                $custom_value = "";

                if ($categorySettingsSiteModuleValue) {

                    $field_value = $categorySettingsSiteModuleValue
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
