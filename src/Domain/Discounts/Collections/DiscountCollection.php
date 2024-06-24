<?php

namespace Domain\Discounts\Collections;

use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Illuminate\Database\Eloquent\Collection;
use Support\Enums\MatchAllAnyInt;

class DiscountCollection extends Collection implements CanBeCheckedForDiscount
{
    public MatchAllAnyInt $match_anyall;

    public function matchOption(MatchAllAnyInt $option): static
    {
        $this->match_anyall = $option;

        return $this;
    }
}
