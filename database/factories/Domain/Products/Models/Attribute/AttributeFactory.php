<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'type_id' => AttributeType::firstOrFactory(),
            'show_in_details' => true,
            'show_in_search' => true,
        ];
    }
}
