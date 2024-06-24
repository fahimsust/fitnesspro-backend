<?php

namespace Database\Factories\Domain\Orders\Models\Product;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemCustomField;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductCustomFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItemCustomField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orders_products_id' => function () {
                return OrderItem::firstOrFactory()->id;
            },
            'form_id' => function () {
                return CustomForm::firstOrFactory()->id;
            },
            'section_id' => function () {
                return FormSection::firstOrFactory()->id;
            },
            'field_id' => function () {
                return CustomField::firstOrFactory()->id;
            },
            'value' => $this->faker->words(3, true),
        ];
    }
}
