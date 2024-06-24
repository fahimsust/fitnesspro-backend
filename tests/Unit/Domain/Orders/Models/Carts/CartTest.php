<?php

namespace Tests\Unit\Domain\Orders\Models\Carts;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Enums\Cart\CartRelations;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function GuzzleHttp\Promise\all;

class CartTest extends TestCase
{
    private Cart $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = Cart::factory()->create();
    }

    /** @test */
    public function can_get_site()
    {
        $this->assertInstanceOf(Site::class, $this->cart->site);
    }

    /** @test */
    public function get_registration()
    {
        Registration::factory()
            ->for($this->cart)
            ->create();

        $this->cart->update([
            'is_registration' => true
        ]);

        $this->assertInstanceOf(Registration::class, $this->cart->registration);
    }

    /** @test */
    public function can_get_totals()
    {
        CartItem::factory(3)->create();

        $this->assertGreaterThan(0, $this->cart->subTotal());
        $this->assertEquals(
            $this->cart->items->reduce(
                fn(?float $carry, CartItem $item) => bcadd($carry, $item->totalAmount()),
                0
            ),
            $this->cart->subTotal()
        );

        CartItemDiscountAdvantage::factory()->create();
        CartItemDiscountAdvantage::factory()->create([
            'item_id' => CartItem::all()->skip(1)->first()
        ]);

        CartDiscountAdvantage::factory()->create();

        $this->assertGreaterThan(0, $this->cart->itemsDiscountTotal());
        $this->assertEquals(
            $this->cart->items()
                ->select('cart_id')
                ->withSum(
                    ['discountAdvantages' => function ($query) {
                        return $query->select(DB::raw("SUM(qty * amount)"));
                    }],
                    'itemsDiscountTotal',
                )
                ->get()
                ->sum('discount_advantages_sum_items_discount_total'),
            $this->cart->itemsDiscountTotal()
        );

        $this->assertGreaterThan(0, $this->cart->discountTotal());
        $this->assertEquals(
            $this->cart->discountAdvantages()
                ->withWhereHas(
                    'advantage.discount',
                    fn(Builder $query) => $query->active()
                )
                ->sum('amount'),
            $this->cart->discountTotal()
        );

        $this->assertGreaterThan(0, $this->cart->total());
        $this->assertEquals(
            $this->cart->subTotal() - $this->cart->discountTotal(),
            $this->cart->total()
        );

        $this->assertGreaterThan(0, $this->cart->weightTotal());
        $this->assertEquals(
            $this->cart->items->sum(
                fn(CartItem $item) => $item->weightTotal()
            ),
            $this->cart->weightTotal()
        );
    }

    /** @test */
    public function can_get_account()
    {
        $this->cart->update(['account_id' => Account::firstOrFactory()->id]);

        $this->assertInstanceOf(Account::class, $this->cart->account);
    }

    /** @test */
    public function can_get_discounts()
    {
        CartDiscount::factory(3)
            ->for($this->cart)
            ->create([
                'discount_id' => Discount::factory()
            ]);

        $this->assertCount(3, $this->cart->{CartRelations::CART_DISCOUNTS});
        $this->assertInstanceOf(CartDiscount::class, $this->cart->{CartRelations::CART_DISCOUNTS}->first());
    }

    /** @test */
    public function can_get_discount_codes()
    {
        CartDiscountCode::factory(3)
            ->for(
                CartDiscount::factory()
                    ->for($this->cart)
                    ->create()
            )
            ->create();

        $this->assertCount(3, $this->cart->discountCodes);
        $this->assertInstanceOf(CartDiscountCode::class, $this->cart->discountCodes->first());
    }

    /** @todo */
    public function can_get_discount_advantages()
    {
        $cartDiscount = CartDiscount::factory()
            ->for($this->cart)
            ->create();

        CartDiscountAdvantage::factory(3)
            ->for($cartDiscount)
            ->create([
                'advantage_id' => DiscountAdvantage::factory()
            ]);

        $advantages = $this->cart->discountAdvantages()
            ->with('advantage.discount')
            ->get();

        $this->assertCount(3, $advantages);
        $this->assertEquals(
            $this->cart->discountAdvantages()->withWhereHas(
                'advantage.discount',
                fn(Builder $query) => $query->active()
            )
                ->sum('amount'),
            $this->cart->discountTotal()
        );
    }

    /** @test */
    public function can_get_items()
    {
        $this->assertFalse($this->cart->hasItems());

        $items = CartItem::factory(3)->create([
            'cart_id' => $this->cart->id,
            'product_id' => Product::factory()
        ]);

        $this->assertEquals(
            $items->reduce(
                fn(?float $carry, CartItem $item) => bcadd($item->totalAmount(), $carry),
                0
            ),
            $this->cart->refresh()->subTotal()
        );
        $this->assertTrue($this->cart->hasItems());
        $this->assertInstanceOf(CartItem::class, $this->cart->items->first());
    }

//    /** @test */
//    public function can_get_checkout()
//    {
//
//    }
}
