<?php

namespace Domain\Sites\Actions;

use App\Api\Admin\Sites\Requests\SiteSettingModuleValueRequest;
use Domain\Sites\Models\SiteSettingsModuleValue;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateSiteSettingModuleValue
{
    use AsObject;

    public function handle(
        SiteSettingModuleValueRequest $request
    ) {
        SiteSettingsModuleValue::updateOrCreate(
            [
                'site_id'=>$request->site_id,
                'section'=>$request->section,
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
