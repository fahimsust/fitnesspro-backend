<?php

namespace Domain\Orders\Actions\Cart\Item\Qty;

use App\Api\Orders\Exceptions\Cart\ItemQtyAdjustedWarning;
use Domain\Orders\Dtos\CartItemDto;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class CheckLimitOrderQtyToAvailableQty implements CanReceiveExceptionCollection
{
    use AsObject,
        HasExceptionCollection;

    public int $qty;
    public ?int $adjustedQty = null;

    private bool $adjustForLimits = true;
    private CartItemDto $dto;

    public function handle(CartItemDto $dto): static
    {
        if (
            ! $dto->product->isInventoried()
            || ! $dto->site->settings->limitOrderQtyToAvailableQty()
            || ! ($dto->getQty() > 1)
            || ! ($dto->getQty() > $dto->availableStockQty)
        ) {
            return $this;
        }

        $error = 'Quantity exceeded maximum available for `:item`';

        if (! $this->adjustForLimits) {
            throw new \Exception(
                __($error, [
                    'item' => $dto->product->title,
                ])
            );
        }

        $this->adjustedQty = $dto->availableStockQty;

        $this->catchToCollection(new ItemQtyAdjustedWarning(
            __($error . ', so quantity has been set to current available qty', [
                'item' => $dto->product->title,
            ])
        ));

        return $this;
    }

    public function adjustForLimits(bool $bool = true): static
    {
        $this->adjustForLimits = $bool;

        return $this;
    }
}
