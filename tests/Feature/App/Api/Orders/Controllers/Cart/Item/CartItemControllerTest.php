<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart\Item;

use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Models\Carts\Cart;
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

class CartItemControllerTest extends TestCase
{
    use TestsCart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createCartWithItem();
    }

    /** @test */
    public function can_get_cart_item_details()
    {
        SaveCartToSession::run($this->cart);

        $response = $this->getJson(route('cart.item.show', $this->cartItem))
            ->assertOk()
            ->assertJsonStructure([
                'item' => [
                    'product',
                    'option_values',
                    'custom_fields',
                    'distributor',
                    'accessory_linked_action_items',
                    'discount_advantages'
                ]
            ]);
//        dd($response->json());
    }

    /** @test */
    public function will_fail_if_cart_item_not_in_cart()
    {
        SaveCartToSession::run($this->cart);

        $otherCartItem = CartItem::factory()
            ->for(Cart::factory())
            ->create();

        $response = $this->getJson(route('cart.item.show', $otherCartItem))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonFragment(['exception' => NotFoundHttpException::class]);
    }
}
