<?php

namespace Tests\Feature\App\Api\Orders\Controllers\Cart\Discount;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Actions\Cart\SaveCartToSession;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Feature\Domain\Orders\Traits\TestsCart;
use Tests\Feature\Domain\Orders\Traits\TestsDiscountCodes;
use Tests\TestCase;

class CartDiscountCodeControllerTest extends TestCase
{
    use TestsDiscountCodes,
        TestsCart;

    private Collection $appliedCartDiscounts;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createCartWithItem();
    }

    /** @test */
    public function get_list_of_codes_on_cart()
    {
        $this->applyCodesToCart();

        $response = $this->getJson(route('cart.discount-code.index'))
            ->assertOk()
            ->assertJsonCount(3, 'discounts')
            ->assertJsonStructure([
                'discounts' => [
                    '*' => [
                        'id',
                        'code',
                        'display',
                    ]
                ]
            ]);

//        dd($response->json());
    }

    /** @test */
    public function apply_code_to_cart()
    {
        SaveCartToSession::run($this->cart);
        $this->createDiscountCode('test');

        $response = $this->postJson(route('cart.discount-code.store'), [
            'discount_code' => 'test'
        ])
            ->assertCreated()
            ->assertJsonStructure([
                'cart' => ['items', 'discounts'],
                'discount'
            ]);

//        dd($response->json());
    }

    /** @test */
    public function can_fail_with_wrong_code()
    {
        SaveCartToSession::run($this->cart);
        $this->createDiscountCode('test');

        $response = $this->postJson(route('cart.discount-code.store'), [
            'discount_code' => 'wrong'
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrorFor('discount_code');

//        dd($response->json());
    }

    /** @test */
    public function remove_code_from_cart()
    {
        $this->applyCodesToCart();

        $this->assertDatabaseCount(CartDiscount::Table(), 4);

        $response = $this->deleteJson(
            route(
                'cart.discount-code.destroy',
                $this->appliedCartDiscounts->first()->id
            )
        )
            ->assertOk()
            ->assertJsonCount(3, 'cart.discounts')
            ->assertJsonStructure([
                'cart' => [
                    'items',
                    'discounts'
                ]
            ]);

        $this->assertDatabaseCount(CartDiscount::Table(), 3);
    }

    /** @test */
    public function will_fail_remove_if_discount_id_not_found()
    {
        $this->applyCodesToCart();

        $response = $this->deleteJson(
            route(
                'cart.discount-code.destroy',
                1
            )
        )
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonFragment(['exception' => NotFoundHttpException::class]);
    }

    /**
     * @return void
     */
    protected function applyCodesToCart(): void
    {
        $codes = CartDiscountCode::factory(3)
            ->create([
                'cart_discount_id' => CartDiscount::factory([
                    'discount_id' => Discount::factory()
                ])
                    ->for($this->cart)
            ]);

        $this->appliedCartDiscounts = CartDiscount::whereCartId($this->cart->id)
            ->get()
            ->each(
                fn(CartDiscount $discount) => CartDiscountAdvantage::factory()
                    ->for($discount)
                    ->create()
            );

        SaveCartToSession::run($this->cart);
    }
}
