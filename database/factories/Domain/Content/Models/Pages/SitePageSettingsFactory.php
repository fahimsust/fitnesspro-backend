<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Content\Models\Pages\SitePageSettings;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SitePageSettingsFactory extends Factory
{
    protected $model = SitePageSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_id'=>Page::firstOrFactory(),
            'site_id'=>Site::firstOrFactory(),
            'settings_template_id'=>PageSettingsTemplate::firstOrFactory(),
            'layout_id'=>Layout::firstOrFactory(),
            'module_template_id' => ModuleTemplate::firstOrFactory(),
        ];
    }
}
