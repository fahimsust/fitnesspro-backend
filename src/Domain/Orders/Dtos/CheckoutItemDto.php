<?php

namespace Domain\Orders\Dtos;

use Domain\Orders\Contracts\ItemDto;
use Domain\Orders\Contracts\PackageDto;
use Domain\Orders\Contracts\ShipmentDto;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutItemDiscount;
use Domain\Orders\Traits\IsItemDto;
use Spatie\LaravelData\Data;

class CheckoutItemDto extends Data
    implements ItemDto
{
    use IsItemDto;

    public ?CheckoutItem $checkoutItem = null;

    public static function fromCheckoutItem(CheckoutItem $item): static
    {
        $obj = self::fromCartItem($item->cartItemCached());

        $item->loadMissingReturn('discounts')
            ->each(
                fn(CheckoutItemDiscount $discount) => $obj->appliedAdvantages->push(
                    AssignedDiscountAdvantageDto::fromCheckoutItemDiscount($discount)
                )
            );

        $obj->checkoutItem = $item;

        return $obj;
    }

    public function toCheckoutItem(): array
    {
        return [
            'product_id' => $this->product->id,
            'cart_item_id' => $this->cartItem->id,
            'qty' => $this->orderQty,
        ];
    }

    public function checkoutReferenceId(): string
    {
        return http_build_query([
            'actual_product_id' => $this->product->id,
            'product_qty' => $this->orderQty,
            'product_price' => $this->priceReg,
            'product_saleprice' => $this->priceSale ?? 0,
            'product_onsale' => $this->onSale,
            'free_from_discount_advantage' => $this->freeFromDiscountAdvantageId
        ]);
    }

    public function createShipmentDtoWith(): CheckoutShipmentDto|ShipmentDto
    {
        return new CheckoutShipmentDto(
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
        return new CheckoutPackageDto();
    }
}
