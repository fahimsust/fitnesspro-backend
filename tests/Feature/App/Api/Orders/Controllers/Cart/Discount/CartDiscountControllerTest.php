<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart\Discount;

use App\Api\Orders\Exceptions\Cart\CartMissingFromSession;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Actions\Cart\StartCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;
use function route;

class CartDiscountControllerTest extends TestCase
{
    private Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function can_get_list_of_cart_discounts()
    {
        $this->startCart();

        CartDiscount::factory(3)
            ->for($this->cart)
            ->create();

        $response = $this->getJson(route('cart.discount.index'))
//        dd($response->json());
            ->assertJsonCount(3, 'discounts');
    }

    /** @test */
    public function will_error_if_cart_doesnt_exist()
    {
        $response = $this->getJson(route('cart.discount.index'))
            ->assertJsonFragment(['exception' => CartMissingFromSession::class]);
//        dd($response->json());
    }

    /** @test */
    public function can_remove_discount_from_cart()
    {
        $this->startCart();

        $cartDiscount = CartDiscount::factory(3)
            ->for($this->cart)
            ->create()
            ->first();

        $this->assertDatabaseCount(CartDiscount::Table(), 3);

        $response = $this->deleteJson(
            route('cart.discount.destroy', $cartDiscount)
        )
            ->assertOk()
            ->assertJsonCount(2, 'cart.discounts');

        $this->assertDatabaseCount(CartDiscount::Table(), 2);
//        dd($response->json());
    }

    /** @test */
    public function will_fail_if_try_to_remove_another_carts_discount()
    {
        $this->startCart();

        CartDiscount::factory(3)
            ->for($this->cart)
            ->create();

        $cartDiscount = CartDiscount::factory()
            ->for(Cart::factory()->create())
            ->create();

        $this->assertDatabaseCount(CartDiscount::Table(), 4);

        $response = $this->deleteJson(
            route('cart.discount.destroy', $cartDiscount)
        )
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonFragment(['exception' => NotFoundHttpException::class]);

        $this->assertDatabaseCount(CartDiscount::Table(), 4);
//        dd($response->json());
    }

    protected function startCart(): void
    {
        SaveCartToSession::run(
            $this->cart = StartCart::run()
        );
    }
}
