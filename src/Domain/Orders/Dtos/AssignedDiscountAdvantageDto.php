<?php

namespace Domain\Orders\Dtos;

use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Domain\Orders\Models\Checkout\CheckoutItemDiscount;
use Domain\Orders\Traits\DtoUsesProductWithEntities;
use Spatie\LaravelData\Data;

class AssignedDiscountAdvantageDto extends Data
{
    use DtoUsesProductWithEntities;

    public function __construct(
        public int     $advantageId,
        public int     $discountId,
        public int     $qty,
        public ?string $display = null,
        public ?string $amount = null,
    )
    {
    }

    public static function fromCartItemAdvantage(
        CartItemDiscountAdvantage $advantage,
        int                       $appliedQty
    ): static
    {
        return new static(
            $advantage->advantage_id,
            $advantage->discount_id,
            $appliedQty,
            $advantage->discount->display,
            $advantage->advantage->type->amount(
                $advantage->advantage->amount
            )
        );
    }

    public static function fromCheckoutItemDiscount(
        CheckoutItemDiscount $discount,
    ): static
    {
        return new static(
            advantageId: $discount->advantage_id,
            discountId: $discount->discount_id,
            qty: $discount->qty,
            display: $discount->discountCached()->display,
            amount: $discount->amount
        );
    }

    public function toItemDiscountModel(): array
    {
        return [
            'discount_id' => $this->discountId,
            'advantage_id' => $this->advantageId,
            'qty' => $this->qty,
            'amount' => $this->amount,
        ];
    }
}
