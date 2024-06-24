<?php

namespace Tests\Feature\Domain\Orders\Actions\Cart\Shipment;

use Domain\Orders\Actions\Checkout\Shipment\BuildShipmentDtosFromCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Tests\Feature\Traits\TestCarts;
use Tests\TestCase;

class BuildShipmentDtosFromCartTest extends TestCase
{
    use TestCarts;

    /** @test */
    public function can()
    {
        $this->createCartItems();
        $this->cart = Cart::first();

        $this->assertCount(3, $this->cart->items);
        $this->assertCount(1, $this->cart->discountAdvantages);

        $shipments = BuildShipmentDtosFromCart::now($this->cart);

        $this->assertCount(2, $shipments);//two separate distributors for 3 items
        $this->assertCount(1, $shipments->first()->packages);
        $this->assertCount(1, $shipments->last()->packages);
    }

    /** @test */
    public function can_split_item_qty_for_package_weight()
    {
        $this->prepProducts();

        $product = $this->products->first();
        $product->update(['weight' => config('shipments.max_package_weight')]);

        CartItem::factory()
            ->for($product)
            ->create([
                'distributor_id' => $this->distributors->first()->id,
                'qty' => 2
            ]);

        $this->cart = Cart::first();

        $this->assertCount(1, $this->cart->items);

        $shipments = BuildShipmentDtosFromCart::now($this->cart);

        $this->assertCount(1, $shipments);
        $this->assertCount(2, $shipments->first()->packages);
    }


    /** @test */
    public function can_split_item_qty_for_shipment_weight()
    {
        $this->prepProducts();

        $product = $this->products->first();
        $product->update(['weight' => 999.99]);

        $qtyPerShipment = bcdiv(config('shipments.max_weight'), $product->weight);

        $qty = bcmul(
            $qtyPerShipment,
            2
        );

        CartItem::factory()
            ->for($product)
            ->create([
                'distributor_id' => $this->distributors->first()->id,
                'qty' => $qty
            ]);

        $this->cart = Cart::first();

        $this->assertCount(1, $this->cart->items);

        $shipments = BuildShipmentDtosFromCart::now($this->cart);

        $this->assertCount(2, $shipments);
        $this->assertCount($qtyPerShipment, $shipments->first()->packages);
        $this->assertCount($qtyPerShipment, $shipments->last()->packages);
    }
}
