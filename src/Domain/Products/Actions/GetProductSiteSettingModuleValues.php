<?php

namespace Domain\Products\Actions;

use App\Api\Admin\Products\Requests\ProductSiteSettingModuleValueSearchRequest;
use Domain\Modules\Actions\GetModuleFieldOptions;
use Domain\Modules\Models\Module;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductSiteSettingModuleValues
{
    use AsObject;

    public function handle(
        ProductSiteSettingModuleValueSearchRequest $request
    ) {
        $fields = [];
        $module = Module::whereId($request->module_id)->first();
        $productSettingModuleValues = $module->productSiteSettingsModuleValue()
        ->where('product_id', $request->product_id)
        ->where('site_id', $request->site_id)
        ->where('section_id', $request->section_id)->get();
        $fieldModules = $module->fields()
        ->orderBy('id')->get();
        if ($fieldModules) {
            foreach ($fieldModules as $field) {
                $custom_value = "";

                if ($productSettingModuleValues) {

                    $field_value = $productSettingModuleValues
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
