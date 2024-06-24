<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductSettingsTemplates\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Domain\Sites\Models\Layout\Layout;
use Worksome\RequestFactories\RequestFactory;

class ProductSettingsTemplateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_detail')]);
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_thumbnail')]);
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_zoom')]);
        return [
            'name'=>$this->faker->word,
            'layout_id'=>Layout::firstOrFactory()->id,
            'module_template_id'=>ModuleTemplate::firstOrFactory()->id,
            'product_detail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_detail')])->id,
            'product_thumbnail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_thumbnail')])->id,
            'product_zoom_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_zoom')])->id,
            'layout_id_default'=>1,
            'module_template_id_default'=>1,
            'product_detail_template_default'=>1,
            'product_thumbnail_template_default'=>1,
            'product_zoom_template_default'=>1
        ];
    }
}
