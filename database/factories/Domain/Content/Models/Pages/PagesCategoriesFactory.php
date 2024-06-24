<?php

namespace Database\Factories\Domain\Content\Models\Pages;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageCategory;
use Domain\Content\Models\Pages\PagesCategories;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagesCategoriesFactory extends Factory
{
    protected $model = PagesCategories::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_id'=>Page::firstOrFactory(),
            'category_id'=>PageCategory::firstOrFactory(),
            'rank'=>$this->faker->randomDigit,
        ];
    }
}
