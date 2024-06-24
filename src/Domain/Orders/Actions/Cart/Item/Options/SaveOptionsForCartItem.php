<?php

namespace Domain\Orders\Actions\Cart\Item\Options;

use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Dtos\OptionCustomValuesData;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class SaveOptionsForCartItem extends AbstractAction
{
    public Collection $optionCustomValues;

    public function __construct(
        protected CartItem    $item,
        protected CartItemDto $dto
    )
    {
    }

    public function execute(): ?CartItem
    {
        if ($this->dto->optionValues->isEmpty()) {
            return null;
        }

        $this->optionCustomValues = $this->item->optionValues()
            ->createMany(
                $this->dto->optionValues
                    ->filter(
                        fn(OptionCustomValuesData $optionCustomValues) => $this->hasCustomValue($optionCustomValues)
                    )
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

//    private function recordOptionCustomValue(CartItemOption $itemOption, CartItemData $dto)
//    {
//        $this->optionCustomValues->push(
//            SaveOptionCustomValuesForCartItem::run(
//                $itemOption,
//                $dto->optionCustomValues['custom_values'][$itemOption->option_value_id]
//            )
//        );
//    }
}
