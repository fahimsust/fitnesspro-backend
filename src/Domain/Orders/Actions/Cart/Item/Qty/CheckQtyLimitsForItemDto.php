<?php

namespace Domain\Orders\Actions\Cart\Item\Qty;

use App\Api\Orders\Exceptions\Cart\ItemQtyAdjustedWarning;
use Domain\Orders\Dtos\CartItemDto;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\AbstractAction;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class CheckQtyLimitsForItemDto
    extends AbstractAction
    implements CanReceiveExceptionCollection
{
    use HasExceptionCollection;

    private bool $adjustForLimits = true;

    public function __construct(
        protected CartItemDto $dto,
        public int            $qty
    )
    {
    }

    public function execute(): static
    {
        if ($this->qty <= 0) {
            throw new \Exception(
                __('Failed to update `:item` qty - qty must be greater than 0', [
                    'item' => $this->dto->product->title,
                ])
            );
        }

        $this->checkMaxQty()
            ->checkMinQty()
            ->checkRegistryQty()
            ->checkAvailableQty();

        return $this;
    }

    public function adjustForLimits(bool $bool = true): static
    {
        $this->adjustForLimits = $bool;

        return $this;
    }

    private function checkMaxQty(): static
    {
        if (!($this->dto->pricing->max_qty > 0) || $this->qty <= $this->dto->pricing->max_qty) {
            return $this;
        }

        $error = 'Quantity exceeded maximum for :item';

        if (!$this->adjustForLimits) {
            throw $this->exception($error);
        }

        $this->qty = $this->dto->pricing->max_qty;
        $this->catchToCollection($this->warning($error . ', so quantity has been set to max allowed'));

        return $this;
    }

    private function checkMinQty(): static
    {
        if ($this->qty >= $this->dto->pricing->min_qty) {
            return $this;
        }

        $error = 'Quantity below minimum requirement for :item';

        if (!$this->adjustForLimits) {
            throw $this->exception($error);
        }

        $this->qty = $this->dto->pricing->min_qty;
        $this->catchToCollection($this->warning($error . ', so quantity has been set to minimum allowed'));

        return $this;
    }

    private function checkRegistryQty()
    {
        if (is_null($this->dto->registryItem)
            || $this->qty <= $this->dto->registryItem->qty_wanted) {
            return $this;
        }

        $error = 'Quantity is greater than needed for gift registry item `:item`';

        if (!$this->adjustForLimits) {
            throw $this->exception($error);
        }

        $this->qty = $this->dto->registryItem->qty_wanted;
        $this->catchToCollection($this->warning($error . ', so qty has been reduced'));

        return $this;
    }

    private function checkAvailableQty()
    {
        $this->qty = CheckLimitOrderQtyToAvailableQty::run($this->dto)
            ->transferExceptionsTo($this)
            ->adjustedQty ?? $this->qty;
    }

    private function exception(string $error): \Exception
    {
        return new \Exception(
            __($error, [
                'item' => $this->dto->product->title,
            ])
        );
    }

    private function warning(string $error)
    {
        return new ItemQtyAdjustedWarning(
            __($error, [
                'item' => $this->dto->product->title,
            ])
        );
    }
}
