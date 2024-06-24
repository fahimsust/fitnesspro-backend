<?php

namespace Database\Factories\Domain\Products\Models\BookingAs;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\BookingAs\BookingAs;
use Domain\Products\Models\BookingAs\BookingAsProduct;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingAsProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookingAsProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product' => Product::firstOrFactory(),
            'bookingas_id' => BookingAs::firstOrFactory(),
        ];
    }
}
