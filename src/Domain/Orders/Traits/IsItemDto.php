<?php

namespace Domain\Orders\Traits;

use Domain\Distributors\Models\Distributor;
use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Orders\Actions\GetProductAvailabilityForProduct;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Actions\Distributors\LoadProductDistributorWithDistributor;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;

trait IsItemDto
{
    use DtoUsesProductWithEntities{
        DtoUsesProductWithEntities::__construct as protected __constructDtoUsesProductWithEntities;
    }

    public float $priceReg = 0;
    public ?float $priceSale = null;
    public bool $onSale = false;
    public int $freeFromDiscountAdvantageId = 0;

    public Collection $options;
    public Collection $appliedAdvantages;

    public function __construct(Site $site, Product $product, int $orderQty = 1)
    {
        $this->__constructDtoUsesProductWithEntities($site, $product, $orderQty);

        $this->options = collect();
        $this->appliedAdvantages = collect();
    }

    public static function fromCartItem(CartItem $cartItem): static
    {
        $cart = $cartItem->cartCached();
        $site = $cart->siteCached();
        $product = $cartItem->productCached();

        $pricing = $product->pricingBySiteCached($site);

        $productDist = LoadProductDistributorWithDistributor::now(
            $product->id,
            $cartItem->distributor_id ?? $product->defaultDistributorId()
        );

        return (new static(
            site: $site,
            product: $product,
            orderQty: $cartItem->qty,
        ))
            ->cartItem($cartItem)
            ->pricing($pricing)
            ->parentProduct($cartItem->parentProductCached())
            ->parentCartItem($cartItem->parentItem)
            ->distributor($cartItem->distributorCached())
            ->productDistributor($productDist)
            ->options($cartItem->optionValues()->get() ?? collect())
            ->customFields($cartItem->customFields?->toArray() ?? [])
            ->accessoryFieldId($cartItem->accessory_field_id ?: null)
            ->label($cartItem->product_label)
            ->registryItem($cartItem->registryItem)
            ->availableStockQty($product->combined_stock_qty)
            ->availability(GetProductAvailabilityForProduct::now(
                $product,
                $productDist->distributor_id
            ))
            ->priceReg($cartItem->price_reg)
            ->priceSale($cartItem->price_sale)
            ->onSale($cartItem->onsale === true)
            ->freeFromDiscountAdvantageId($cartItem->free_from_discount_advantage_id ?? 0)
            ->discountAdvantages($cartItem->discountAdvantages);
    }


    public function pricing(ProductPricing $productPricing): static
    {
        $this->pricing = $productPricing;
        $this->priceReg = $productPricing->price_reg;
        $this->priceSale = $productPricing->price_sale;
        $this->onSale = $productPricing->on_sale === true;

        return $this;
    }

    public function priceReg(float $priceReg): static
    {
        $this->priceReg = $priceReg;

        return $this;
    }

    public function priceSale(?float $priceSale): static
    {
        $this->priceSale = $priceSale;

        return $this;
    }

    public function onSale(bool $onSale): static
    {
        $this->onSale = $onSale;

        return $this;
    }

    public function freeFromDiscountAdvantageId(int $freeFromDiscountAdvantageId): static
    {
        $this->freeFromDiscountAdvantageId = $freeFromDiscountAdvantageId;

        return $this;
    }

    public function options(iterable $options): static
    {
        $this->options = $options;

        return $this;
    }
}
