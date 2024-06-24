<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart;

use App\Api\Orders\Exceptions\Cart\CartMissingFromSession;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Actions\Cart\StartCart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\ProductPricing;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class CartControllerTest extends TestCase
{
    /** @test */
    public function can_get_cart_data()
    {
        SaveCartToSession::run(
            StartCart::run()
        );

        $response = $this->getJson(route('cart.index'))
            ->assertOk()
            ->assertJsonStructure([
                'cart' => ['id', 'status', 'account_id', 'items', 'site_id', 'discounts']
            ]);

//        dd($response->json());
    }

    /** @test */
    public function will_error_if_cart_not_set_and_try_to_get_data()
    {
        $response = $this->getJson(route('cart.index'))
            ->assertNotFound()
            ->assertJsonFragment(['exception' => CartMissingFromSession::class]);

//        dd($response->json());
    }

    /** @test */
    public function can_empty_cart()
    {
        SaveCartToSession::run(
            $cart = StartCart::run()
        );

        CartItem::factory(3)
            ->for($cart)
            ->create([
                'product_id' => ProductPricing::factory()->create()->product_id
            ]);

        CartDiscountAdvantage::factory(3)
            ->for(CartDiscount::factory()
                ->for($cart)
                ->create()
            )
            ->create([
                'advantage_id' => DiscountAdvantage::factory()
            ]);

        $this->assertDatabaseCount(CartItem::Table(), 3);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 3);

        $response = $this->deleteJson(route('cart.destroy'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'cart'
            ]);

        $this->assertDatabaseCount(CartItem::Table(), 0);
        $this->assertDatabaseCount(CartDiscountAdvantage::Table(), 0);

//        dd($response->json());
    }

    /** @test */
    public function empty_cart_will_fail_if_no_cart()
    {
        $response = $this->deleteJson(route('cart.destroy'))
            ->assertNotFound()
            ->assertJsonFragment(['exception' => CartMissingFromSession::class]);

//        dd($response->json());
    }
}
