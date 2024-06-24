<?php

namespace Database\Factories\Domain\Products\Models\Product\Specialties;

use Domain\Accounts\Models\Specialty;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Specialties\ProductSpecialty;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSpecialtyFactory extends Factory
{
    protected $model = ProductSpecialty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'specialty_id' => Specialty::firstOrFactory(),
        ];
    }
}
