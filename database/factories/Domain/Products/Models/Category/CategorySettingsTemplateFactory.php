<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Products\Models\Category\CategorySettingsTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorySettingsTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategorySettingsTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'module_custom_values'=>''
        ];
    }
}
