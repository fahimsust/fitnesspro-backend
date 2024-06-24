<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart\Item;

use App\Api\Orders\Exceptions\Cart\CartDoesNotMatchAccount;
use App\Api\Orders\Requests\Cart\AddItemToCartRequest;
use Domain\Accounts\Models\Account;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSectionField;
use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Actions\Cart\StartCart;
use Domain\Orders\Dtos\CustomFormFieldValueData;
use Domain\Orders\Dtos\OptionCustomValuesData;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItemCustomField;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Products\Enums\ProductOptionCustomTypes;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionCustom;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;
use function config;
use function route;

class CartItemControllerStoreTest extends TestCase
{
    use HasTestAccount;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSettings::factory()
            ->for(
                Site::firstOrFactory(['id' => config('site.id')])
            )
            ->create();
    }

    /** @test */
    public function can_start_cart_and_add_simple_item_to_cart_without_account()
    {
        $pricing = ProductPricing::firstOrFactory();

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');

//        dd($response->json());
    }

    /** @test */
    public function can_add_and_affect_discounts()
    {
        DiscountCondition::factory()
            ->create([
                'condition_type_id' => DiscountConditionTypes::MINIMUM_CART_AMOUNT,
                'required_cart_value' => 100
            ]);

        DiscountAdvantage::factory()->create([
            'advantage_type_id' => DiscountAdvantageTypes::PERCENTAGE_OFF_ORDER,
            'amount' => 10
        ]);

        $pricing = ProductPricing::firstOrFactory([
            'price_reg' => 100,
            'onsale' => false
        ]);

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1
        ]);

        $this->assertDatabaseCount(CartDiscount::Table(), 0);

        //todo discount total is not returned with 4 decimals
        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonFragment([
                'subtotal' => 100,
                'total' => 90,
                'discount_total' => 10
            ])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');

        $this->assertDatabaseCount(CartDiscount::Table(), 1);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 1);

//        dd($response->json());
    }

    /** @test */
    public function can_start_cart_and_add_simple_item_to_cart_with_account()
    {
        $this->createLoginAccount(); //create/login this->account

        $pricing = ProductPricing::firstOrFactory();

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['account_id' => $this->account->id])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');
//        dd($response->json());
    }

    /** @test */
    public function can_use_existing_cart_and_add_simple_item()
    {
        SaveCartToSession::run(
            $cart = StartCart::run()
        );

        $pricing = ProductPricing::firstOrFactory();

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');

        $this->assertEquals($cart->id, $response->json('cart')['id']);
//        dd($response->json());
    }

    /** @test */
    public function can_use_existing_cart_and_add_matrix_item()
    {
        SaveCartToSession::run(
            $cart = StartCart::run()
        );

        $pricing = ProductPricing::firstOrFactory();

        $parent = ProductPricing::factory()
            ->for(Product::factory()->create(['parent_product' => null]))
            ->create();

        $pricing->product->update(['parent_product' => $parent->product->id]);

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');

        $this->assertEquals($cart->id, $response->json('cart')['id']);
//        dd($response->json());
    }

    /** @test */
    public function can_handle_missing_product()
    {
        AddItemToCartRequest::fake([
            'product_id' => 2,
            'qty' => 1
        ]);

        $repsonse = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrorFor('product_id');
//        dd($repsonse->json());
    }


    /** @test */
    public function can_handle_mismatch_account()
    {
        $this->createLoginAccount(); //create/login this->account

        SaveCartToSession::run(
            $cart = StartCart::now(account: Account::factory()->create())
        );

        AddItemToCartRequest::fake([
            'product_id' => ProductPricing::firstOrFactory()->product_id,
            'qty' => 1
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertJsonFragment(['exception' => CartDoesNotMatchAccount::class]);
//        dd($response->json());
    }

    /** @test */
    public function can_add_with_option_custom_values()
    {
        $pricing = ProductPricing::firstOrFactory();

        $parent = ProductPricing::factory()
            ->for(Product::factory()->create(['parent_product' => null]))
            ->create();

        $pricing->product->update(['parent_product' => $parent->product->id]);

        ProductOptionCustom::factory()
            ->for($optionValue = ProductOptionValue::factory()
                ->for(
                    ProductOption::factory()
                        ->for($parent->product)->create(),
                    'option'
                )
                ->create(),
                'optionValue'
            )
            ->create(['custom_type' => ProductOptionCustomTypes::TEXT]);

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1,
            'option_custom_values' => [
                (new OptionCustomValuesData(
                    $optionValue->id,
                    'custom text dummy value'
                ))->toArray()
            ]
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');

        $this->assertDatabaseCount(CartItemOption::Table(), 1);
//        dd($response->json());
    }

    /** @test */
    public function can_add_with_custom_fields()
    {
        $pricing = ProductPricing::firstOrFactory();

        $formSectionField = FormSectionField::factory()->create();

        AddItemToCartRequest::fake([
            'product_id' => $pricing->product_id,
            'qty' => 1,
            'custom_field_values' => [
                (new CustomFormFieldValueData(
                    CustomForm::first()->id,
                    $formSectionField->section_id,
                    $formSectionField->field_id,
                    fake()->word
                ))->toArray()
            ]
        ]);

        $response = $this->postJson(route('cart.item.store'))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSessionHas('cart')
            ->assertJsonStructure(['cart', 'item', 'exceptions'])
            ->assertJsonFragment(['product_id' => $pricing->product_id])
            ->assertJsonCount(1, 'cart.items')
            ->assertJsonCount(0, 'exceptions');

        $this->assertDatabaseCount(CartItemCustomField::Table(), 1);

//        dd($response->json());
    }

    /** @test */
    public function add_request_can_validate()
    {
        $this->postJson(route('cart.item.store'))
            ->assertStatus(422);
    }
}
