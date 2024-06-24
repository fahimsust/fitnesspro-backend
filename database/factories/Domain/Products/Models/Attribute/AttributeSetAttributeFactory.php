<?php

namespace Database\Factories\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeSetAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeSetAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'set_id' => function () {
                return AttributeSet::firstOrFactory()->id;
            },
            'attribute_id' => function () {
                return Attribute::factory()->create()->id;
            },
        ];
    }
}
