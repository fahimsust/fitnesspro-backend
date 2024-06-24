<?php

namespace Support\Enums;

use Support\Actions\ConvertIntPriceToFloat;

enum AmountAdjustmentTypes: int
{
    case PERCENTAGE = 0;
    case AMOUNT = 1;

    public function calculateAdjustment(int $adjustmentAmount, int $amountToAdjust)
    {
        return match ($this) {
            self::PERCENTAGE => $adjustmentAmount / 100 * $amountToAdjust,
            default => $adjustmentAmount
        };
    }

    public function adjustAmount(int $adjustmentAmount, int $amountToAdjust): int
    {
        $calculatedAdjustment = $this->calculateAdjustment($adjustmentAmount, $amountToAdjust);

        return $amountToAdjust + $calculatedAdjustment;
    }
}
