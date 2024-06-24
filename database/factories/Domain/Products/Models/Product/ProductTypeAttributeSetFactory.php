<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTypeAttributeSetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductTypeAttributeSet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => ProductType::firstOrFactory(),
            'set_id' => AttributeSet::firstOrFactory(),
        ];
    }
}
