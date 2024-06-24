<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Discounts\Traits\ChecksCartItemsForDiscountCondition;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CheckProductAttributeMatchesCondition extends CartConditionCheck
{
    use ChecksCartItemsForDiscountCondition;

    private Collection $attributeOptions;

    public function check(): bool
    {
        $this->attributeOptions()
            ->whenEmpty(
                fn() => $this->failed(
                    __('No attribute options found'),
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
        $this->attributeOptions()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                $this->checkAttributeAgainstItems(...)
            );

        return $this->completeCheckConditionWithRequiredQtyCombined();
    }

    protected function checkConditionWithRequiredQtyIndividual(): bool
    {
        $this->success = null;

        $this->attributeOptions()
            ->takeUntil(fn() => $this->success != null)
            ->each(
                function (AttributeOption $option) use (&$success) {
                    $this->resetFoundAndNeededQty(
                        $option->pivot->required_qty
                    );

                    $this->checkAttributeAgainstItems($option);

                    $this->setCheckRequiredQtyIndividualSuccess(
                        $option->pivot->required_qty
                    );
                }
            );

        return $this->checkSetSuccessIfMatchAll();
    }

    protected function checkAttributeAgainstItems(
        AttributeOption $attributeOption
    ): void
    {
        $this->cart->itemsCached()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                fn(CartItem $item) => $this->checkApplyConditionAgainstItem(
                    $item,
                    $attributeOption,
                )
            );
    }

    protected function checkApplyConditionAgainstItem(
        CartItem        $item,
        AttributeOption $attributeOption,
    ): void
    {
        $cartItemDto = CartItemDto::fromCartItem($item);

        info(
            "Check " .
            $cartItemDto->product->title .
            " attributes " .
            implode(", ", $cartItemDto->product->details->attributes) .
            (($this->condition->checkEquals()) ? ' in ' : ' not in ') .
            $attributeOption->id
        );

        if ($item->isAutoAdded()) {
            info(" - is auto added");
            return;
        }

        if (!$this->conditionMatchesCartItem($attributeOption, $cartItemDto)) {
            info(" - doesn't match");
            return;
        }

        $useQty = $this->applyUseQtyForConditionProduct($item);

        if ($useQty > 0) {
            $this->checkerData->useForRuleProduct(
                $this->condition->rule,
                $item,
            );
        }
    }

    private function attributeOptions(): Collection
    {
        return $this->attributeOptions ??= $this->condition
            ->cachedRelation('attributeOptions');
    }

    protected function conditionMatchesCartItem(
        AttributeOption $attributeOption,
        CartItemDto     $cartItemDto
    ): bool
    {
        if ($this->condition->checkEquals()) {
            //check if equals
            return in_array($attributeOption->id, $cartItemDto->product->details->attributes);
        }

        //check if not equals
        return !in_array($attributeOption->id, $cartItemDto->product->details->attributes);
    }
}
