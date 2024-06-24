<?php

namespace Tests\Feature\App\Api\Admin\Orders\Controllers;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderCustomForm;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderCustomFormControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_order_custom_form_list()
    {
        // Create order, product, product details, custom form, and form sections
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $productDetails = ProductDetail::factory()->create(['product_id' => $product->id]);
        $customForm = CustomForm::factory()->create();
        $sections = FormSection::factory(rand(2, 3))->create(['form_id' => $customForm->id]);

        // Create form fields and associate them with form sections
        foreach ($sections as $section) {
            $field = CustomField::factory()->create();
            FormSectionField::factory()->create([
                'section_id' => $section->id,
                'field_id' => $field->id
            ]);
            $formValue[$customForm->id][$section->id][$field->id] = "test order";
            $formValue2[$customForm->id . "-" . $product->id . "-" . $productDetails->type_id][$section->id][$field->id] = "test product";
        }

        // Create order custom forms with form values
        OrderCustomForm::factory()->create([
            'form_id' => $customForm->id,
            'order_id' => $order->id,
            'product_id' => null,
            'product_type_id' => null,
            'form_count' => 0,
            'form_values' => $formValue
        ]);
        OrderCustomForm::factory()->create([
            'form_id' => $customForm->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_type_id' => $productDetails->type_id,
            'form_count' => 0,
            'form_values' => $formValue2
        ]);
        $result = $this->getJson(route('admin.order.custom-forms.index', [$order]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'form' => [
                        'sections' => ['*' => [
                            'fields'
                        ]]
                    ],
                    'created',
                    'form_values'
                ]
            ]])
            ->assertJsonCount(2, 'data');
        $result->assertJson([
            'data' => [
                [
                    'form_values' => $formValue
                ],
                [
                    'form_values' => $formValue2
                ]
            ]
        ]);
    }
    /** @test */
    public function can_update_custom_form()
    {
        $order = Order::factory()->create();
        $orderCustomForm = OrderCustomForm::factory()->create([
            'order_id' => $order->id,
        ]);
        $product = Product::factory()->create();
        $productType = ProductType::factory()->create();
        $productDetails = ProductDetail::factory()->create(['product_id' => $product->id]);
        $customForm = CustomForm::factory()->create();
        $sections = FormSection::factory(rand(2, 3))->create(['form_id' => $customForm->id]);
        $formValue = [];
        foreach ($sections as $section) {
            $field = CustomField::factory()->create();
            FormSectionField::factory()->create([
                'section_id' => $section->id,
                'field_id' => $field->id
            ]);

            $formValue[$customForm->id . "-" . $product->id . "-" . $productDetails->type_id][$section->id][$field->id] = "test product";
        }

        $this->putJson(
            route('admin.order.custom-forms.update', [$order, $orderCustomForm]),
            [
                'form_id' => $customForm->id,
                'product_id' => $product->id,
                'product_type_id' => $productType->id,
                'form_values' => $formValue,
            ]
        )
            ->assertCreated();

        $this->assertEquals($formValue, $orderCustomForm->refresh()->form_values);
    }
}
