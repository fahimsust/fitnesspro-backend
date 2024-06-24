<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Enums\ProductReviewItemTypes;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Products\Models\Product\ProductRelated;
use Domain\Products\Models\Product\ProductReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $item_type = $this->faker->randomElement(
            ProductReviewItemTypes::cases()
        );
        return [
            'item_type' => $item_type,
            'item_id' => $item_type->value == 0? Product::firstOrFactory():AttributeOption::firstOrFactory(),
            'name' => $this->faker->name,
            'comment' => $this->faker->sentence(3),
            'rating' => rand(1,5),
            'approved'=>false,
            'rating' => mt_rand(1, 5),
            'approved' => false
        ];
    }
}
