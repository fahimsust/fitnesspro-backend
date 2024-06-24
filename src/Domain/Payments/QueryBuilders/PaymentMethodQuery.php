<?php

namespace Domain\Payments\QueryBuilders;

use Domain\Payments\Enums\PaymentMethodStatus;
use Illuminate\Database\Eloquent\Builder;

class PaymentMethodQuery extends Builder
{
    public function active(): static
    {
        return $this->where(['status' => PaymentMethodStatus::ACTIVE]);
    }

    public function forSubscription(int $siteId): static
    {
        return $this->withWhereHas(
            'subscriptionOption',
            fn ($query) => $query->forSite($siteId)
        );
    }

    public function forCheckout(int $siteId): static
    {
        return $this->withWhereHas(
            'checkoutOption',
            fn ($query) => $query->forSite($siteId)
        );
    }

    public function checkoutOptions(int $siteId): static
    {
        return $this
            ->active()
            ->forCheckout($siteId);
    }

    public function subscriptionOptions(int $siteId): static
    {
        return $this
            ->active()
            ->forSubscription($siteId);
    }
}
