<?php

namespace Tests\Feature\Traits;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Collection;

trait TestCarts
{
    protected ?Site $site = null;
    protected Cart $cart;

    protected ?Collection $products = null;
    protected ?Collection $distributors = null;

    protected function prepSite()
    {
        $this->site = Site::firstOrFactory();

        SiteSettings::factory()
            ->for($this->site)
            ->create([
                'cart_allowavailability' => ProductAvailability::factory(3)
                    ->create()
                    ->pluck('id')
                    ->toArray()
            ]);
    }

    protected function prepProducts()
    {
        if (!$this->site) {
            $this->prepSite();
        }

        $this->products = Product::factory(3)
            ->sequence(
                [
                    'combined_stock_qty' => rand(1, 3),
                    'weight' => rand(5, 15),
                ],
                [
                    'combined_stock_qty' => rand(1, 3),
                    'weight' => rand(5, 15),
                ],
                [
                    'combined_stock_qty' => rand(1, 3),
                    'weight' => rand(5, 15),
                ],
            )
            ->create();

        $this->distributors = Distributor::factory(2)->create();

        $this->products->each(
            function (Product $product) {
                ProductPricing::factory()
                    ->create([
                        'product_id' => $product->id,
                        'site_id' => $this->site->id
                    ]);

                ProductDistributor::factory()
                    ->create([
                        'product_id' => $product->id,
                        'distributor_id' => $this->distributors->first()->id
                    ]);
            }
        );

        ProductDistributor::all()->last()->update([
            'distributor_id' => $this->distributors->last()->id
        ]);
    }

    protected function createCartItems()
    {
        if(!$this->products) {
            $this->prepProducts();
        }

        CartItem::factory(3)
            ->sequence(
                [
                    'product_id' => $this->products->first()->id,
                    'distributor_id' => $this->distributors->first()->id,
                    'qty' => rand(1, 3),
                ],
                [
                    'product_id' => $this->products->get(1)->id,
                    'distributor_id' => $this->distributors->first()->id,
                    'qty' => rand(1, 3),
                ],
                [
                    'product_id' => $this->products->last()->id,
                    'distributor_id' => $this->distributors->last()->id,
                    'qty' => rand(1, 3),
                ]
            )
            ->create();

        CartDiscountAdvantage::factory()->create();
    }
}
