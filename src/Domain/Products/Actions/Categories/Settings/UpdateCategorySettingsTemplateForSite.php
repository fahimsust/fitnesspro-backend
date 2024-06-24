<?php

namespace Domain\Products\Actions\Categories\Settings;

use App\Api\Admin\Categories\Requests\CategorySiteSettingsRequest;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySiteSettings;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCategorySettingsTemplateForSite
{
    use AsObject;

    public function handle(
        Category $category,
        CategorySiteSettingsRequest $request
    ): CategorySiteSettings {
        $category->siteSettings()->updateOrCreate(
            [
                'site_id' => $request->site_id,
            ],
            [
                'settings_template_id' => $request->settings_template_id_default == 1?$request->settings_template_id:null,
                'settings_template_id_default' => $request->settings_template_id_default,
                'module_template_id' => $request->module_template_id,
                'module_template_id_default' => $request->module_template_id_default,
            ]
        );

        return GetCategorySiteSettings::run($category, $request->site_id);
    }
}
