<?php

namespace Domain\Discounts\Dtos;

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Spatie\LaravelData\Data;

class DiscountCheckerData extends Data
{
    public array $useProductForRule = [];
    public array $itemUseDiscount = [];
    public array $itemUseForDiscountCondition = [];
    public array $itemUseForAdvantage = [];
    public array $toBeAssignUseForCondition = [];

    public function isForRuleProduct(
        DiscountRule $rule,
        CartItem     $item
    ): bool
    {
        if (!is_array($this->useProductForRule[$rule->id])) {
            return false;
        }

        info("Check if " .
            $item->id .
            " in use_product_for_rule[" . $rule->id . "] - " .
            implode(", ", $this->useProductForRule[$rule->id])
        );

        return in_array($item->id, $this->useProductForRule[$rule->id]);
    }

    public function calcUseQtyForConditionProduct(
        int               $neededQty,
        DiscountCondition $condition,
        CartItem          $item
    ): int
    {
        info("calcUseQtyForConditionProduct start with qty=" . $item->qty);

        $availToUseQty = $item->qty;

        if (
            isset($this->itemUseForDiscountCondition[$condition->id])
            && $this->itemUseForDiscountCondition[$condition->id] > 0
        ) {
            info("use_for_discount_condition = " . $this->itemUseForDiscountCondition[$condition->id]);
            $availToUseQty -= $this->itemUseForDiscountCondition[$condition->id];
        }

        if (isset($this->toBeAssignUseForCondition[$condition->id])) {
            info("tobe_assignuse_forcondition is set");
            foreach ($this->toBeAssignUseForCondition[$condition->id] as $item_id => $qty) {
                info($item_id . " minus " . $qty);
                $availToUseQty -= $qty;
            }
        }

        info("availToUseQty = " . $availToUseQty);
        if ($availToUseQty > 0) {
            if ($availToUseQty > $neededQty) {
                info("avail_to_use_Qty > neededQty, so set use_qty to neededQty");
                $use_qty = $neededQty;
            } else $use_qty = $availToUseQty;

            return $use_qty;
        }

        return 0;
    }

    public function useForRuleProduct(
        DiscountRule $rule,
        CartItem     $item
    ): static
    {
        $this->useProductForRule[$rule->id][] = $item->id;

        return $this;
    }

    function removeItemDiscounts(CartItem $item)
    {
        unset($this->itemUseDiscount[$item->id]);
        unset($this->itemUseForAdvantage[$item->id]);
        unset($this->itemUseForDiscountCondition[$item->id]);
    }

    function itemUseForDiscount(
        CartItem $item,
        int      $discountId,
        int      $qty
    )
    {
        $this->itemUseDiscount[$item->id][$discountId] = $qty;
    }

    function itemUseForCondition(
        CartItem $item,
        int      $conditionId,
        int      $qty
    )
    {
        $this->itemUseForDiscountCondition[$item->id][$conditionId] += $qty;
    }

    function itemUseForAdvantage(
        CartItem $item,
        int      $advantageId,
        int      $qty
    )
    {
        $this->itemUseForAdvantage[$item->id][$advantageId] = $qty;
    }
}
