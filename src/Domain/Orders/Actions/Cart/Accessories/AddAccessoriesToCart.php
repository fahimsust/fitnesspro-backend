<?php

namespace Domain\Orders\Actions\Cart\Accessories;

use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class AddAccessoriesToCart
    extends AbstractAction
    implements CanReceiveExceptionCollection
{
    use         HasExceptionCollection;

    public Collection $addedCartItems;

    public function __construct(
        public Cart        $cart,
        public CartItem    $cartItem,
        public ?Collection $productAccessoriesWithAccessoryDto = null
    )
    {
    }

    public function execute(): static
    {
        if (is_null($this->productAccessoriesWithAccessoryDto)) {
            return $this;
        }

        $this->addedCartItems = collect();

        $this->productAccessoriesWithAccessoryDto
            ->map(
                fn(AccessoryData $accessoryData) => $this->buildCartItemDtoForAccessory($accessoryData)
            )
            ->each(
                fn(CartItemDto $dto) => $this->addToCart($dto)
            );

        return $this;
    }

    private function buildCartItemDtoForAccessory(AccessoryData $accessoryData): CartItemDto
    {
        $cartItemDto = LoadProductWithEntitiesForCartItem::run(
            $accessoryData->productId,
            $this->cart->site
        )
            ->toCartItemDto(
                $accessoryData->qty,
                $accessoryData->options
            );

        if ($accessoryData->productAccessory->show_as_option) {
            $cartItemDto->parentCartItem($this->cartItem);
        }

        if ($accessoryData->productAccessory->link_actions) {
            $cartItemDto->accessoryLinkedActions($this->cartItem);
        }

        return $cartItemDto;
    }

    private function addToCart(CartItemDto $dto)
    {
        $this->addedCartItems->push(
            AddItemToCartFromDto::run(
                $this->cart,
                $dto,
                checkRequiredAccessories: false
            )
                ->transferExceptionsTo($this)
                ->result()
        );
    }
}
