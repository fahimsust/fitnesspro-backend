<?php

namespace Database\Factories\Domain\Messaging\Models;

use Domain\Messaging\Models\MessageTemplateCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageTemplateCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MessageTemplateCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        return [
            'name' => $faker->words(2, true),
            'parent_id' => null
        ];
    }
}
