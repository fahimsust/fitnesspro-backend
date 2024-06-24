<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\ProductSettingsTemplates\Requests\ProductSettingsTemplateRequest;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Lorisleiva\Actions\Concerns\AsObject;

class ModifyProductSettingTemplate
{
    use AsObject;

    public function handle(
        ProductSettingsTemplate $productSettingsTemplate,
        ProductSettingsTemplateRequest $request,
    ) {
        return $productSettingsTemplate->update(
            [
                'name' => $request->name,
                'layout_id' => $request->layout_id_default == 1?$request->layout_id:null,
                'module_template_id' => $request->module_template_id_default == 1?$request->module_template_id:null,
                'product_detail_template' => $request->product_detail_template_default == 1?$request->product_detail_template:null,
                'product_thumbnail_template' => $request->product_thumbnail_template_default == 1?$request->product_thumbnail_template:null,
                'product_zoom_template' => $request->product_zoom_template_default == 1?$request->product_zoom_template:null,
                'layout_id_default' => $request->layout_id_default,
                'module_template_id_default' => $request->module_template_id_default,
                'product_detail_template_default' => $request->product_detail_template_default,
                'product_thumbnail_template_default' => $request->product_thumbnail_template_default,
                'product_zoom_template_default' => $request->product_zoom_template_default,
            ]
        );
    }
}
