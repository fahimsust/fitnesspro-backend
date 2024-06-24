<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartItems;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemCustomField;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartItems\CartItemOptionOld>
 */
class CartItemCustomFieldFactory extends Factory
{
    protected $model = CartItemCustomField::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_id' => CartItem::firstOrFactory(),
            'form_id' => CustomForm::firstOrFactory(),
            'section_id' => FormSection::firstOrFactory(),
            'field_id' => CustomField::firstOrFactory(),
            'value' => $this->faker->word
        ];
    }
}
