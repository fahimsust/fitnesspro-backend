<?php

namespace Tests\Unit\Domain\Orders\Models\Carts\Items;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemCustomField;
use Tests\TestCase;

class CartItemCustomFieldTest extends TestCase
{
    private CartItemCustomField $customField;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customField = CartItemCustomField::factory()->create();
    }

    /** @todo */
    public function can_get_item()
    {
        $this->assertInstanceOf(
            CartItem::class,
            $this->customField->item
        );
    }

    /** @todo */
    public function can_get_custom_field()
    {
        $this->assertInstanceOf(
            CustomField::class,
            $this->customField->field
        );
    }

    /** @todo */
    public function can_get_form()
    {
        $this->assertInstanceOf(
            CustomForm::class,
            $this->customField->form
        );
    }

    /** @todo */
    public function can_get_form_section()
    {
        $this->assertInstanceOf(
            FormSection::class,
            $this->customField->section
        );
    }
}
