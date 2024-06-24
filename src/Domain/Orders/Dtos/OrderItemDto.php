<?php

namespace Domain\Orders\Dtos;

use Domain\Orders\Actions\GetProductAvailabilityForProduct;
use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Traits\IsItemDto;
use Domain\Products\Actions\Distributors\LoadProductDistributorWithDistributor;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Spatie\LaravelData\Data;

class OrderItemDto extends Data
    implements ItemDto
{
    use IsItemDto;

    public ?OrderItem $orderItem = null;

    public static function fromCheckoutItem(CheckoutItem $item): static
    {
        $obj = static::fromCartItem($item->cartItemCached());

        $obj->orderQty = $item->qty;

        return $obj;
    }

    public static function usingProduct(Product $product): static
    {
        $site = app(Site::class);
        $pricing = $product->pricingBySiteCached($site);

        $productDist = LoadProductDistributorWithDistributor::now(
            $product->id,
            $product->defaultDistributorId()
        );

        return (new static(
            site: $site,
            product: $product,
            orderQty: 1,
        ))
            ->pricing($pricing)
            ->parentProduct($product->parent)
            ->distributor($product->defaultDistributor)
            ->productDistributor($productDist)
            ->availability(GetProductAvailabilityForProduct::now(
                $product,
                $productDist->distributor_id
            ))
            ->priceReg($pricing->price_reg)
            ->priceSale($pricing->price_sale)
            ->onSale($pricing->on_sale === true);
    }

    public function toModelArray(int $orderId): array
    {
        return [
            'cart_item_id' => $this->cartItem?->id,
            'registry_item_id' => $this->registryItem?->id,
            'order_id' => $orderId,
            'product_id' => $this->product->id,
            'actual_product_id' => $this->product->id,
            'product_label' => $this->label ?? "",
            'product_qty' => $this->orderQty,
            'parent_product_id' => $this->parentProduct?->id,
            'product_price' => $this->priceReg,
            'product_saleprice' => $this->priceSale ?? 0,
            'product_onsale' => $this->onSale,
            'free_from_discount_advantage' => $this->freeFromDiscountAdvantageId
        ];
    }

    public function createShipmentDtoWith(): OrderShipmentDto|ShipmentDto
    {
        return new OrderShipmentDto(
            isDigital: $this->product->isDigital(),
            distributorId: $this->distributor->id,
            distributor: $this->distributor,
            registry: $this->cartItem->isRegistryItem()
                ? $this->cartItem->registryItem->registry
                : null
        );
    }

    public function createPackageDtoWith(): PackageDto
    {
        return new OrderPackageDto();
    }
}
