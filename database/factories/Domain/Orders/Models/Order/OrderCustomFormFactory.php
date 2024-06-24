<?php

namespace Database\Factories\Domain\Orders\Models\Order;

use Domain\CustomForms\Models\CustomForm;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderCustomForm;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderCustomFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderCustomForm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'=>Order::firstOrFactory(),
            'form_id'=>CustomForm::firstOrFactory(),
            'product_id'=>Product::firstOrFactory(),
            'product_type_id'=>ProductType::firstOrFactory(),
            'form_count'=>$this->faker->randomDigit,
            'form_values'=>$this->faker->sentence,
        ];
    }
}
