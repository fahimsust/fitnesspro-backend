<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Discounts\Traits\ChecksCartItemsForDiscountCondition;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CheckProductAvailabilityMatchesCondition extends CartConditionCheck
{
    use ChecksCartItemsForDiscountCondition;

    private Collection $availabilities;

    public function check(): bool
    {

        $this->availabilities()
            ->whenEmpty(
                fn() => $this->failed(
                    __('No availabilities found'),
                    Response::HTTP_NOT_ACCEPTABLE
                )
            );

        if ($this->condition->required_qty_type->isCombined()) {
            $this->neededQty = $this->condition->required_qty_combined;

            return $this->checkConditionWithRequiredQtyCombined();
        }

        return $this->checkConditionWithRequiredQtyIndividual();
    }


    protected function checkConditionWithRequiredQtyCombined(): bool
    {
        $this->availabilities()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                $this->checkStatusAgainstItems(...)
            );

        return $this->completeCheckConditionWithRequiredQtyCombined();
    }

    protected function checkConditionWithRequiredQtyIndividual(): bool
    {
        $this->success = null;

        $this->availabilities()
            ->takeUntil(fn() => $this->success != null)
            ->each(
                function (ProductAvailability $availability) use (&$success) {
                    $this->resetFoundAndNeededQty(
                        $availability->pivot->required_qty
                    );

                    $this->checkStatusAgainstItems($availability);

                    $this->setCheckRequiredQtyIndividualSuccess(
                        $availability->pivot->required_qty
                    );
                }
            );

        return $this->checkSetSuccessIfMatchAll();
    }

    protected function checkStatusAgainstItems(
        ProductAvailability $availability
    ): void
    {
        $this->cart->itemsCached()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                fn(CartItem $item) => $this->checkApplyStatusAgainstItem(
                    $item,
                    $availability,
                )
            );
    }

    protected function checkApplyStatusAgainstItem(
        CartItem            $item,
        ProductAvailability $availability,
    ): void
    {
        $cartItemDto = CartItemDto::fromCartItem($item);

        info(
            "Check ".
            $cartItemDto->product->title .
            " availability ".
            $cartItemDto->availability->id .
            (($this->condition->checkEquals()) ? '=':'!=').
            $availability->id
        );

        if ($item->isAutoAdded()) {
            info(" - is auto added");
            return;
        }

        if (
            $this->condition->use_with_rules_products
            && !$this->checkerData->isForRuleProduct($this->condition->rule, $item)
        ) {
            info("isForRuleProduct returned false");

            return;
        }

        if (
            ($this->condition->checkEquals() && $cartItemDto->availability->id == $availability->id)
            ||
            (!$this->condition->checkEquals() && $cartItemDto->availability->id != $availability->id)
        ) {
            $this->applyUseQtyForConditionProduct($item);

            return;
        }

        info(" - doesn't match");
    }

    private function availabilities(): Collection
    {
        return $this->availabilities ??= $this->condition
            ->cachedRelation('productAvailabilities');
    }
}
