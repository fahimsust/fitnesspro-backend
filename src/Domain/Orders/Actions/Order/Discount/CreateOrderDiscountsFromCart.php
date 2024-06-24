<?php

namespace Domain\Orders\Actions\Order\Discount;

use Domain\Orders\Enums\Cart\CartRelations;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class CreateOrderDiscountsFromCart extends AbstractAction
{
    public function __construct(
        public Order $order,
        public Cart  $cart,
    )
    {
    }

    public function execute(): Collection
    {
        $create = $this->cart->discountAdvantages()
            ->with(CartRelations::CART_DISCOUNTS)
            ->get()
            ->map(
                function (CartDiscountAdvantage $cartDiscountAdvantage) {
                    return [
                        'discount_id' => $cartDiscountAdvantage
                            ->cartDiscount
                            ->discount_id,
                        'amount' => $cartDiscountAdvantage->amount,
                        'advantage_id' => $cartDiscountAdvantage->advantage_id,
                    ];
                }
            );

        if ($create->isEmpty()) {
            return collect();
        }

        $this->order->setRelation(
            'discounts',
            $created = $this->order->discounts()
                ->createMany(
                    $create->toArray()
                )
        );

        return $created;
    }
}
