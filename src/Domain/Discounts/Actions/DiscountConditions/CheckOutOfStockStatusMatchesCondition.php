<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Discounts\Traits\ChecksCartItemsForDiscountCondition;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CheckOutOfStockStatusMatchesCondition extends CartConditionCheck
{
    use ChecksCartItemsForDiscountCondition;

    private Collection $outOfStatuses;

    public function check(): bool
    {
        $this->outOfStatuses()
            ->whenEmpty(
                fn() => $this->failed(
                    __('No out of stock statuses found'),
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
        $this->outOfStatuses()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                $this->checkStatusAgainstItems(...)
            );

        return $this->completeCheckConditionWithRequiredQtyCombined();
    }

    protected function checkConditionWithRequiredQtyIndividual(): bool
    {
        $this->success = null;

        $this->outOfStatuses()
            ->takeUntil(fn() => $this->success != null)
            ->each(
                function (ProductAvailability $outOfStockStatus) {
                    $this->resetFoundAndNeededQty(
                        $outOfStockStatus->pivot->required_qty
                    );

                    $this->checkStatusAgainstItems($outOfStockStatus);

                    $this->setCheckRequiredQtyIndividualSuccess(
                        $outOfStockStatus->pivot->required_qty
                    );
                }
            );

        return $this->checkSetSuccessIfMatchAll();
    }

    protected function checkStatusAgainstItems(
        ProductAvailability $outOfStockStatus
    ): void
    {
        $this->cart->itemsCached()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                fn(CartItem $item) => $this->checkApplyStatusAgainstItem(
                    $item,
                    $outOfStockStatus,
                )
            );
    }

    protected function checkApplyStatusAgainstItem(
        CartItem            $item,
        ProductAvailability $outOfStockStatus,
    ): void
    {
        $cartItemDto = CartItemDto::fromCartItem($item);

        info(
            "Check " .
            $cartItemDto->product->title .
            " out of stock status " .
            $cartItemDto->outOfStockStatusId() .
            (($this->condition->checkEquals()) ? '=' : '!=') .
            $outOfStockStatus->id
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
            ($this->condition->checkEquals() && $cartItemDto->outOfStockStatusId() == $outOfStockStatus->id)
            ||
            (!$this->condition->checkEquals() && $cartItemDto->outOfStockStatusId() != $outOfStockStatus->id)
        ) {
            $this->applyUseQtyForConditionProduct($item);

            return;
        }

        info(" - doesn't match");
    }

    private function outOfStatuses(): Collection
    {
        return $this->outOfStatuses ??= $this->condition
            ->cachedRelation('outOfStockStatuses');
    }
}
