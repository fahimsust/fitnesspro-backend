<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\CategorySettingsTemplates\Requests\CategorySettingsTemplateRequest;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateCategorySettingTemplate
{
    use AsObject;

    public function handle(
        CategorySettingsTemplateRequest $request
    ): CategorySettingsTemplate {
        return CategorySettingsTemplate::create(
            [
                'name' => $request->name,
                'layout_id' => $request->layout_id_default == 1?$request->layout_id:null,
                'module_template_id' => $request->module_template_id_default == 1?$request->module_template_id:null,
                'layout_id_default' => $request->layout_id_default,
                'module_template_id_default' => $request->module_template_id_default,
                'category_thumbnail_template' => $request->category_thumbnail_template,
                'feature_thumbnail_template' => $request->feature_thumbnail_template,
                'product_thumbnail_template' => $request->product_thumbnail_template,
                'show_categories_in_body' => $request->show_categories_in_body,
                'show_featured' => $request->show_featured,
                'feature_defaultsort' => $request->feature_defaultsort,
                'feature_showsort' => $request->feature_showsort,
                'feature_showmessage' => $request->feature_showmessage,
                'feature_thumbnail_count' => $request->feature_thumbnail_count,
                'show_products' => $request->show_products,
                'product_thumbnail_showsort' => $request->product_thumbnail_showsort,
                'product_thumbnail_defaultsort' => $request->product_thumbnail_defaultsort,
                'product_thumbnail_count' => $request->product_thumbnail_count,
                'product_thumbnail_showmessage' => $request->product_thumbnail_showmessage,
                'search_form_id' => $request->search_form_id,
            ]
        );
    }
}
