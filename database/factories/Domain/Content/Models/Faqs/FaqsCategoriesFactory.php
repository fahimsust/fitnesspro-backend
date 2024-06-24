<?php

namespace Database\Factories\Domain\Content\Models\Faqs;


use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqsCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqsCategoriesFactory extends Factory
{
    protected $model = FaqsCategories::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'faqs_id' => Faq::firstOrFactory(),
            'categories_id' => FaqCategory::firstOrFactory(),
        ];
    }
}
