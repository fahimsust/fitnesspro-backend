<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Content\Models\Image;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'image_id' => Image::factory()->create(),
            'caption' => $this->faker->sentence(3),
            'rank' => $this->faker->randomNumber(1),
            'show_in_gallery' => $this->faker->boolean(),
        ];
    }
}
