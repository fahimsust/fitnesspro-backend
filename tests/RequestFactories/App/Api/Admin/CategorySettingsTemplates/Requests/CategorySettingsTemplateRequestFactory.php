<?php

namespace Tests\RequestFactories\App\Api\Admin\CategorySettingsTemplates\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Domain\Sites\Models\Layout\Layout;
use Worksome\RequestFactories\RequestFactory;

class CategorySettingsTemplateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.category_thumbnail')]);
        DisplayTemplateType::factory()->create(['id'=>config('display_templates.product_thumbnail')]);
        return [
            'name'=>$this->faker->word,
            'search_form_id'=>SearchForm::firstOrFactory()->id,
            'layout_id'=>Layout::firstOrFactory()->id,
            'module_template_id'=>ModuleTemplate::firstOrFactory()->id,
            'category_thumbnail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.category_thumbnail')])->id,
            'feature_thumbnail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_thumbnail')])->id,
            'product_thumbnail_template' => DisplayTemplate::factory()->create(['type_id'=>config('display_templates.product_thumbnail')])->id,
            'show_categories_in_body'=>1,
            'show_featured'=>1,
            'feature_defaultsort'=>1,
            'feature_showsort'=>1,
            'feature_showmessage'=>1,
            'feature_thumbnail_count'=>1,
            'show_products'=>1,
            'product_thumbnail_showsort'=>1,
            'product_thumbnail_defaultsort'=>1,
            'product_thumbnail_count'=>1,
            'product_thumbnail_showmessage'=>1,
        ];
    }
}
