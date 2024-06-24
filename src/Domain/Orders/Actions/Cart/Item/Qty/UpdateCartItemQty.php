<?php

namespace Domain\Orders\Actions\Cart\Item\Qty;

use Domain\Orders\Actions\Cart\Item\Pricing\CheckAndApplyVolumePricingToCartItem;
use Domain\Orders\Actions\Cart\LinkedAccessories\UpdateLinkedAccessoriesQty;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;
use Symfony\Component\HttpFoundation\Response;

class UpdateCartItemQty implements CanReceiveExceptionCollection
{
    use AsObject,
        HasExceptionCollection;

    public CartItem $item;
    private int $qty;

    private bool $ignoreQtyLimits = false;
    private bool $adjustForLimits = true;

    public function handle(
        CartItem $item,
        int $qty
    ): static {
        if ($item->qty === $qty) {
            throw new \Exception(
                __('Update to qty is the same as current qty'),
                Response::HTTP_CONFLICT
            );
        }

        if ($qty <= 0) {
            throw new \Exception(
                __('Failed to update `:item` qty - qty must be greater than 0', [
                    'item' => $item->product->title,
                ])
            );
        }

        $this->item = $item;
        $this->qty = $qty;

        if ($this->ignoreQtyLimits) {
            $this->updateQty();

            return $this;
        }

        $this->qty = CheckQtyLimitsForItemDto::run(
            CartItemDto::fromCartItem($item),
            $qty
        )
            ->transferExceptionsTo($this)
            ->qty;

        $this->updateQty();

        return $this;
    }

    public function ignoreQtyLimits(bool $bool = true): static
    {
        $this->ignoreQtyLimits = $bool;

        return $this;
    }

    public function adjustForLimits(bool $bool = true): static
    {
        $this->adjustForLimits = $bool;

        return $this;
    }

    private function updateQty(): static
    {
        $this->item->update(['qty' => $this->qty]);

        CheckAndApplyVolumePricingToCartItem::run($this->item, $this->qty);

        UpdateLinkedAccessoriesQty::run($this->item)
            ->transferExceptionsTo($this);

        return $this;
    }
}
