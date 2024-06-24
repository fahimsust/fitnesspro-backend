<?php

namespace Domain\Discounts\Traits;

use Domain\Orders\Models\Carts\CartItems\CartItem;

trait ChecksCartItemsForDiscountCondition
{
    protected array $found = [];
    protected int $foundTotal = 0;
    protected int $neededQty;

    protected ?bool $success = null;

    protected function resetFoundAndNeededQty(
        int $neededQty
    ): void
    {
        $this->found = [];
        $this->foundTotal = 0;
        $this->neededQty = $neededQty;

        info("required qty = " . $this->neededQty);
    }

    protected function setCheckRequiredQtyIndividualSuccess(
        int $requiredQty
    ): void
    {
        info("found total = " . $this->foundTotal);
        if ($this->foundTotal >= $requiredQty) {
            info("toBeAssignUseForCondition for " . implode(",", $this->found));

            $this->checkerData->toBeAssignUseForCondition[$this->condition->id] = $this->found;

            if ($this->condition->match_anyall->isAny()) {
                info("return true cuz only has to match 1");
                $this->success = true;
            }

            return;
        }

        info(__("foundTotal not >= status->required qty :qty, so check fails", [
            'qty' => $requiredQty,
        ]));

        if (!$this->condition->match_anyall->isAny()) {
            info("return false cuz has to match all");
            $this->success = false;
        }
    }

    protected function completeCheckConditionWithRequiredQtyCombined(): bool
    {
        $log = "is foundTotal (" .
            $this->foundTotal .
            ") >= cond->required_qty_combined (" .
            $this->condition->required_qty_combined .
            ")";

        if ($this->foundTotal >= $this->condition->required_qty_combined) {
            info($log . " - Yes, assign found (" . implode(", ", $this->found) . ") to tobe_assignuse_forcondition[" . $this->condition->id . "]");
            $this->checkerData->toBeAssignUseForCondition[$this->condition->id] = $this->found;

            return true;
        }

        info($log . " - No");

        return false;
    }

    public function applyUseQtyForConditionProduct(
        CartItem $item,
    ): int
    {
        info(' - matches');

        $useQty = $this->checkerData->calcUseQtyForConditionProduct(
            $this->neededQty,
            $this->condition,
            $item
        );

        if ($useQty > 0) {
            info("foundTotal = " .
                $this->foundTotal .
                ", found[" . $item->id . "];
                  add " . $useQty
            );

            $this->foundTotal += $useQty;

            if (!isset($this->found[$item->id])) {
                $this->found[$item->id] = 0;
            }

            $this->found[$item->id] += $useQty;

            info("neededQty = " . $this->neededQty . ", minus " . $useQty);
            $this->neededQty -= $useQty;

            if ($this->neededQty == 0) {
                info("neededQty now is 0, return true");
                return $useQty;
            }

            info('neededQty not 0');
            return $useQty;
        }

        info(' - use = ' . $useQty);

        return $useQty;
    }

    protected function checkSetSuccessIfMatchAll(): bool
    {
        if (
            $this->success !== false
            && $this->condition->match_anyall->isAll()
        ) {
            $this->success = true;
        }

        return $this->success;
    }
}
