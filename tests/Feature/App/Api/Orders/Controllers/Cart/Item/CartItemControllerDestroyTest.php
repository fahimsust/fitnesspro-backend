<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart\Item;

use App\Api\Orders\Exceptions\Cart\CartDoesNotMatchAccount;
use App\Api\Orders\Exceptions\Cart\CartMissingFromSession;
use Domain\Accounts\Models\Account;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;
use function config;
use function route;

class CartItemControllerDestroyTest extends TestCase
{
    /** @test */
    public function can_remove_item()
    {
        $this->withoutExceptionHandling();
        $item = CartItem::firstOrFactory([
            'cart_id' => Cart::firstOrFactory(['account_id' => null])
        ]);

        SaveCartToSession::run($item->cart);

        $this->deleteJson(route('cart.item.destroy', $item))
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseCount(CartItem::Table(), 0);
    }

    /** @test */
    public function will_fail_if_cart_missing()
    {
        $this->withoutExceptionHandling()
            ->expectException(CartMissingFromSession::class);

        $this->deleteJson(route('cart.item.destroy', [
            'item' => 1
        ]));
    }

    /** @test */
    public function will_fail_if_cart_item_missing()
    {
        SaveCartToSession::run(
            $cart = Cart::firstOrFactory(['account_id' => null])
        );

        $response = $this->deleteJson(route('cart.item.destroy', [
            'item' => 1
        ]))
            ->assertJsonFragment(['exception' => NotFoundHttpException::class]);
    }

    /** @test */
    public function will_fail_if_cart_owner_mismatch()
    {
        SaveCartToSession::run(
            $cart = Cart::firstOrFactory(['account_id' => Account::firstOrFactory()->id])
        );

        $response = $this->deleteJson(route('cart.item.destroy', [
            'item' => 1
        ]))
            ->assertJsonFragment(['exception' => CartDoesNotMatchAccount::class]);
    }

    /** @test */
    public function will_rework_discounts_if_item_removal_affects()
    {
        $item = CartItem::firstOrFactory([
            'cart_id' => Cart::firstOrFactory(['account_id' => null]),
            'qty' => 1,
            'price_reg' => 400,
            'onsale' => false
        ]);

        ProductPricing::factory()
            ->for($item->product)
            ->for($item->cart->site)
            ->create([
                'price_reg' => 400,
                'onsale' => false
            ]);

        $cartDiscountAdvantage = CartDiscountAdvantage::factory()
            ->for(
                CartDiscount::factory()
                    ->for($item->cart)
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
                'required_cart_value' => 500
            ]);

        $secondaryItem = CartItem::factory()
            ->for($item->cart)
            ->create([
                'qty' => 1,
                'price_reg' => 100,
                'onsale' => false,
                'product_id' => ProductPricing::factory()
                    ->for(Product::factory()->create())
                    ->for($item->cart->site)
                    ->create([
                        'price_reg' => 100,
                        'onsale' => false
                    ])->product_id
            ]);

        SaveCartToSession::run($item->cart);

        $this->assertDatabaseCount(CartDiscount::Table(), 1);
        $this->assertDatabaseCount(CartItem::Table(), 2);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 1);

        $response = $this->deleteJson(route('cart.item.destroy', $item))
            ->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(0, 'cart.discounts');

        $this->assertDatabaseCount(CartItem::Table(), 1);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 0);
        $this->assertDatabaseCount(CartDiscount::Table(), 0);

//        dd($response->json());
    }
}
