<?php

namespace Database\Factories\Domain\CustomForms\Models;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Domain\CustomForms\Models\FormSection;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => CustomForm::firstOrFactory(),
            'product_id' => Product::firstOrFactory(),
            'rank' => mt_rand(1, 10)
        ];
    }
}
