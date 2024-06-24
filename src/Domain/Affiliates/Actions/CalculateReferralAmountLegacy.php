<?php

namespace Domain\Affiliates\Actions;


use Domain\Affiliates\Models\AffiliateLevel;
use Support\Contracts\AbstractAction;

class CalculateReferralAmountLegacy extends AbstractAction
{
    public string $referralAmount = "0";

    public function __construct(
        public AffiliateLevel $level,
        public int            $referralType,
        public float          $amount,
    )
    {
    }

    public function result(): string
    {
        return $this->referralAmount;
    }

    public function execute(): static
    {
        if ($this->referralType == 1) $rate = $this->level->order_rate;
        else $rate = $this->level->subscription_rate;

        if (!($rate > 0))
            return $this;

        $per = $rate / 100;
        $referralAmount = $this->amount * $per;

        $this->referralAmount = number_format((float)$referralAmount, 2, ".", "");

        return $this;
    }
}
