<?php

namespace Domain\Orders\Dtos;

use Spatie\LaravelData\Data;

class CartItemAccessoryFieldDtos extends Data
{
    public function __construct(
        public CartItemDto        $cartItemData,
        public AccessoryFieldData $accessoryFieldData
    ) {
    }
}
