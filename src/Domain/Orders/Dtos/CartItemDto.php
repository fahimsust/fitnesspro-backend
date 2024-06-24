<?php

namespace Domain\Orders\Dtos;

use Domain\Accounts\Models\Registration\Registration;
use Domain\Discounts\Enums\OnSaleStatuses;
use Domain\Orders\Actions\Cart\Item\LoadProductForCartItem;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Actions\GetProductAvailabilityForProduct;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Traits\DtoUsesProductWithEntities;
use Domain\Products\Actions\Distributors\LoadProductDistributorWithDistributor;
use Illuminate\Support\Traits\Conditionable;
use Spatie\LaravelData\Data;

class CartItemDto extends Data
{
    use DtoUsesProductWithEntities,
        Conditionable;

    public ?CartItem $requiredFor = null;
    public ?CartItem $accessoryLinkedActions = null;

    public function requiredFor(CartItem $cartItem): static
    {
        $this->requiredFor = $cartItem;

        return $this;
    }

    public static function fromCartItem(CartItem $item): static
    {
        $product = LoadProductForCartItem::now($item->product_id);

        $item->setRelation(
            'product',
            $product
        );

        $productDist = null;
        if ($item->distributor_id ?? $product->defaultDistributorId()) {
            $productDist = LoadProductDistributorWithDistributor::now(
                $product->id,
                $item->distributor_id ?? $product->defaultDistributorId()
            );
        }

        $item->loadMissing([
            'registryItem',
            'discountAdvantages',
        ]);

        return (new static(
            site: site(),
            product: $product,
            orderQty: $item->qty,
        ))
            ->availableStockQty($product->combined_stock_qty)
            ->registryItem($item->registryItem)
            ->pricing($item->product->pricingBySiteCached(site()))
            ->discountAdvantages($item->discountAdvantages)
            ->distributor(
                $item->distributorCached()
                ?? $product->defaultDistributor
            )
            ->availability(GetProductAvailabilityForProduct::now(
                $product,
                $productDist?->distributor_id
            ))
            ->when(
                isset($productDist),
                fn($dto) => $dto->productDistributor($productDist)
            );
    }

    public static function fromRegistration(Registration $registration): static
    {
        return LoadProductWithEntitiesForCartItem::now(
            childProductId: $registration->levelCached()->annual_product_id,
            site: $registration->siteCached(),
        )
            ->toCartItemDto(
                orderQty: 1,
            );
    }

    public function toModelArray(): array
    {
        return [
            'product_id' => $this->product->id,
            'qty' => $this->getQty(),

            'price_reg' => $this->pricing->regularPrice(),
            'price_sale' => $this->pricing->salePrice(),
            'onsale' => $this->pricing->isOnSale(),

            'parent_product' => $this->parentProduct?->id,
            'parent_cart_item_id' => $this->parentCartItem?->id,
            'required' => $this->requiredFor?->id,
            'product_label' => $this->label,

            'registry_item_id' => $this->registryItem?->id,
            'accessory_field_id' => $this->accessoryFieldId,
            'distributor_id' => $this->distributor?->id,
            'accessory_link_actions' => $this->accessoryLinkedActions?->id,
        ];
    }

    public function outOfStockStatusId(): ?int
    {
        return $this->productDistributor?->outofstockstatus_id
            ?? $this->product->defaultOutOfStockStatusId();
    }

    public function productTypeId(): ?int
    {
        return $this->product->details->type_id
            ?? $this->product->parent?->details?->type_id;
    }

    public function onSaleStatus(): OnSaleStatuses
    {
        return $this->pricing->isOnSale()
            ? OnSaleStatuses::OnSale
            : OnSaleStatuses::NotOnSale;
    }
}
