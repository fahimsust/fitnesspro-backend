<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Discounts\Models\Rule\Condition\ConditionOnSaleStatus;
use Domain\Discounts\Traits\ChecksCartItemsForDiscountCondition;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CheckOnSaleStatusMatchesCondition extends CartConditionCheck
{
    use ChecksCartItemsForDiscountCondition;

    private Collection $onSaleStatuses;

    public function check(): bool
    {
        $this->onSaleStatuses()
            ->whenEmpty(
                fn() => $this->failed(
                    __('No sale statuses found'),
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
        $this->onSaleStatuses()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                $this->checkStatusAgainstItems(...)
            );

        return $this->completeCheckConditionWithRequiredQtyCombined();
    }

    protected function checkConditionWithRequiredQtyIndividual(): bool
    {
        $this->success = null;

        $this->onSaleStatuses()
            ->takeUntil(fn() => $this->success != null)
            ->each(
                function (ConditionOnSaleStatus $conditionSaleStatus) {
                    $this->resetFoundAndNeededQty(
                        $conditionSaleStatus->required_qty
                    );

                    $this->checkStatusAgainstItems($conditionSaleStatus);

                    $this->setCheckRequiredQtyIndividualSuccess(
                        $conditionSaleStatus->required_qty
                    );
                }
            );

        return $this->checkSetSuccessIfMatchAll();
    }

    protected function checkStatusAgainstItems(
        ConditionOnSaleStatus $onSaleStatus
    ): void
    {
        $this->cart->itemsCached()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                fn(CartItem $item) => $this->checkApplyStatusAgainstItem(
                    $item,
                    $onSaleStatus,
                )
            );
    }

    protected function checkApplyStatusAgainstItem(
        CartItem              $item,
        ConditionOnSaleStatus $onSaleStatus,
    ): void
    {
        $cartItemDto = CartItemDto::fromCartItem($item);

        info(
            "Check " .
            $cartItemDto->product->title .
            " on sale status " .
            $cartItemDto->availability->id .
            (($this->condition->checkEquals()) ? '=' : '!=') .
            $onSaleStatus->id
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
            ($this->condition->checkEquals() && $cartItemDto->onSaleStatus() == $onSaleStatus->onsalestatus_id)
            ||
            (!$this->condition->checkEquals() && $cartItemDto->onSaleStatus() != $onSaleStatus->onsalestatus_id)
        ) {
            $this->applyUseQtyForConditionProduct($item);

            return;
        }

        info(" - doesn't match");
    }

    private function onSaleStatuses(): Collection
    {
        return $this->onSaleStatuses ??= $this->condition
            ->cachedRelation('onSaleStatuses');
    }
}
