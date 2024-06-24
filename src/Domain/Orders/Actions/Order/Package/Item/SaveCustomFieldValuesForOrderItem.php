<?php

namespace Domain\Orders\Actions\Order\Package\Item;

use Domain\Orders\Dtos\CustomFormFieldValueData;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Support\Contracts\AbstractAction;

class SaveCustomFieldValuesForOrderItem extends AbstractAction
{
    public function __construct(
        protected OrderItem    $item,
        protected OrderItemDto $dto
    )
    {
    }

    public function execute(): ?OrderItem
    {
        if (!$this->dto->customFieldValues?->count()) {
            return null;
        }

        return $this->item->setRelation(
            'customFields',
            $this->item->customFields()->createMany(
                $this->dto->customFieldValues->map(
                    fn(CustomFormFieldValueData $data) => $data->toArray()
                )
            )
        );
    }
}
