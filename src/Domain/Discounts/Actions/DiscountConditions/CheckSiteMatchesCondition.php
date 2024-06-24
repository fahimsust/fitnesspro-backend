<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\SiteConditionCheck;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteMatchesCondition extends SiteConditionCheck
{
    public function check(): bool
    {
        return in_array($this->site->id, $this->requiredSites())
            ?: $this->failed(
                __('Site is not in discount conditions sites list'),
                Response::HTTP_NOT_ACCEPTABLE
            );
    }

    private function requiredSites(): array
    {
        return $this->condition
            ->loadMissingReturn('sites')
            ->pluck('id')
            ->toArray();
    }
}
