<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\SitePageSettingsModuleValue;
use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SitePageSettingsModuleValueFactory extends Factory
{
    protected $model = SitePageSettingsModuleValue::class;

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
            'section_id'=>LayoutSection::firstOrFactory(),
            'module_id'=>Module::firstOrFactory(),
            'field_id' => ModuleField::firstOrFactory(),
        ];
    }
}
