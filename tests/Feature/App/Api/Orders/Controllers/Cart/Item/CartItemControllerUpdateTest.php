<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart\Item;

use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\SiteSettings;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Feature\Domain\Orders\Traits\TestsCart;
use Tests\TestCase;
use function route;

class CartItemControllerUpdateTest extends TestCase
{
    use TestsCart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createCartWithItem();
    }

    /** @test */
    public function can_update_item_qty()
    {
        SaveCartToSession::run($this->cart);

        SiteSettings::factory()
            ->for($this->cart->site)
            ->create([
                'cart_allowavailability' => ProductAvailability::factory(3)
                    ->create()
                    ->pluck('id')
                    ->toArray()
            ]);

        $pricing = ProductPricing::factory()
            ->for(Product::first())
            ->for($this->cart->site, 'site')
            ->create();

        $response = $this->putJson(
            route('cart.item.update', $this->cartItem),
            ['qty' => 3]
        )
            ->assertOk()
            ->assertJsonStructure([
                'cart' => ['items', 'discounts']
            ]);

        $this->assertDatabaseHas(CartItem::Table(), [
            'id' => $this->cartItem->id,
            'qty' => 3
        ]);

//        dd($response->json());
    }

    /** @test */
    public function can_fail_update_qty()
    {
        SaveCartToSession::run($this->cart);

        $response = $this->putJson(
            route('cart.item.update', $this->cartItem),
            [
                'qty' => 0
            ]
        )
            ->assertJsonValidationErrorFor('qty');

//        dd($response->json());
    }

    /** @test */
    public function will_rework_discounts_if_item_update_affects()
    {
        $this->cartItem->update([
            'qty' => 2,
            'price_reg' => 400,
            'onsale' => false
        ]);

        ProductPricing::factory()
            ->for($this->cartItem->product)
            ->for($this->cartItem->cart->site)
            ->create([
                'price_reg' => 400,
                'onsale' => false
            ]);

        $cartDiscountAdvantage = CartDiscountAdvantage::factory()
            ->for(
                CartDiscount::factory()
                    ->for($this->cartItem->cart)
                    ->create()
            )
            ->create();

        DiscountCondition::factory()
            ->for(
                DiscountRule::factory()
                    ->for($cartDiscountAdvantage->discount)
                    ->create(),
                'rule'
            )
            ->create([
                'condition_type_id' => DiscountConditionTypes::MINIMUM_CART_AMOUNT,
                'required_cart_value' => 800
            ]);

        $secondaryItem = CartItem::factory()
            ->for($this->cartItem->cart)
            ->create([
                'qty' => 1,
                'price_reg' => 100,
                'onsale' => false,
                'product_id' => ProductPricing::factory()
                    ->for(Product::factory()->create())
                    ->for($this->cartItem->cart->site)
                    ->create([
                        'price_reg' => 100,
                        'onsale' => false
                    ])->product_id
            ]);

        SaveCartToSession::run($this->cartItem->cart);

        $this->assertDatabaseCount(CartDiscount::Table(), 1);
        $this->assertDatabaseCount(CartItem::Table(), 2);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 1);

        $response = $this->deleteJson(
            route('cart.item.update', $this->cartItem),
            ['qty' => 1]
        )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(0, 'cart.discounts');

        $this->assertDatabaseCount(CartItem::Table(), 1);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 0);
        $this->assertDatabaseCount(CartDiscount::Table(), 0);

//        dd($response->json());
    }
}
