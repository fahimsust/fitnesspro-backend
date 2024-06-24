<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Orders\Dtos\OptionCustomValuesData;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class SaveOptionsForOrderItem extends AbstractAction
{
    public Collection $optionCustomValues;

    public function __construct(
        protected OrderItem    $item,
        protected OrderItemDto $dto
    )
    {
    }

    public function execute(): ?OrderItem
    {
        if ($this->dto->optionValues->isEmpty()) {
            return null;
        }

        $this->optionCustomValues = $this->item->optionValues()
            ->createMany(
                $this->dto->optionValues
                    ->map(
                        fn(OptionCustomValuesData $optionCustomValues) => $optionCustomValues->toArray()
                    )->toArray()
            );

        return $this->item->setRelation(
            'optionValues',
            $this->optionCustomValues
        );
    }

    private function hasCustomValue(OptionCustomValuesData $optionCustomValue): bool
    {
        return !empty($optionCustomValue->customValue);
    }
}
