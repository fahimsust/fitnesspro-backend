<?php

namespace Domain\Sites\Actions;

use App\Api\Admin\Sites\Requests\SiteSettingModuleValueSearchRequest;
use Domain\Modules\Actions\GetModuleFieldOptions;
use Domain\Modules\Models\Module;
use Lorisleiva\Actions\Concerns\AsObject;

class GetSiteSettingModuleValues
{
    use AsObject;

    public function handle(
        SiteSettingModuleValueSearchRequest $request
    ) {
        $fields = [];
        $module = Module::whereId($request->module_id)->first();
        $siteSettingsModuleValue = $module->siteSettingsModuleValue()
        ->where('section', $request->section)
        ->where('site_id', $request->site_id)
        ->where('section_id', $request->section_id)->get();
        $fieldModules = $module->fields()
        ->orderBy('id')->get();

        if ($fieldModules) {
            foreach ($fieldModules as $field) {
                $custom_value = "";

                if ($siteSettingsModuleValue) {

                    $field_value = $siteSettingsModuleValue
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
