<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Worksome\RequestFactories\RequestFactory;

class ProductSiteSettingsRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_detail')]);
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_thumbnail')]);
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_zoom')]);
        return [
            'site_id' => Site::firstOrFactory()->id,
            'settings_template_id_default'=>1,
            'layout_id_default'=>1,
            'module_template_id_default'=>1,
            'product_detail_template_default'=>1,
            'product_thumbnail_template_default'=>1,
            'product_zoom_template_default'=>1,
            'settings_template_id'=>ProductSettingsTemplate::firstOrFactory()->id,
            'layout_id'=>Layout::firstOrFactory()->id,
            'module_template_id'=>ModuleTemplate::firstOrFactory()->id,
            'product_detail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_detail')])->id,
            'product_thumbnail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_thumbnail')])->id,
            'product_zoom_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_zoom')])->id,
        ];
    }
}
