<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Discounts\Traits\ChecksCartItemsForDiscountCondition;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CheckProductTypeMatchesCondition extends CartConditionCheck
{
    use ChecksCartItemsForDiscountCondition;

    private Collection $productTypes;

    public function check(): bool
    {
        $this->productTypes()
            ->whenEmpty(
                fn() => $this->failed(
                    __('No product types found'),
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
        $this->productTypes()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                $this->checkStatusAgainstItems(...)
            );

        return $this->completeCheckConditionWithRequiredQtyCombined();
    }

    protected function checkConditionWithRequiredQtyIndividual(): bool
    {
        $this->success = null;

        $this->productTypes()
            ->takeUntil(fn() => $this->success != null)
            ->each(
                function (ProductType $productType) use (&$success) {
                    $this->resetFoundAndNeededQty(
                        $productType->pivot->required_qty
                    );

                    $this->checkStatusAgainstItems($productType);

                    $this->setCheckRequiredQtyIndividualSuccess(
                        $productType->pivot->required_qty
                    );
                }
            );

        return $this->checkSetSuccessIfMatchAll();
    }

    protected function checkStatusAgainstItems(
        ProductType $productType
    ): void
    {
        $this->cart->itemsCached()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                fn(CartItem $item) => $this->checkApplyStatusAgainstItem(
                    $item,
                    $productType,
                )
            );
    }

    protected function checkApplyStatusAgainstItem(
        CartItem    $item,
        ProductType $productType,
    ): void
    {
        $cartItemDto = CartItemDto::fromCartItem($item);

        info(
            "Check " .
            $cartItemDto->product->title .
            " out of stock status " .
            $cartItemDto->productTypeId() .
            (($this->condition->checkEquals()) ? '=' : '!=') .
            $productType->id
        );

        if ($item->isAutoAdded()) {
            info(" - is auto added");
            return;
        }

        if (
            ($this->condition->checkEquals() && $cartItemDto->productTypeId() == $productType->id)
            ||
            (!$this->condition->checkEquals() && $cartItemDto->productTypeId() != $productType->id)
        ) {
            $useQty = $this->applyUseQtyForConditionProduct($item);

            if ($useQty > 0) {
                $this->checkerData->useForRuleProduct(
                    $this->condition->rule,
                    $item,
                );
            }

            return;
        }

        info(" - doesn't match");
    }

    private function productTypes(): Collection
    {
        return $this->productTypes ??= $this->condition
            ->cachedRelation('productTypes');
    }
}
