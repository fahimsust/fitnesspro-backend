<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Accounts\Models\Account;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class CheckProductAgainstOrderingRule implements CanReceiveExceptionCollection
{
    use AsObject,
        HasExceptionCollection;

    public function handle(
        Site     $site,
        Product  $product,
        ?Account $account = null
    ): static
    {
        if (!$product->pricingBySiteCached($site)->hasOrderingRule()) {
            return $this;
        }

        CheckOrderingRule::run(
            $product->pricingBySiteCached($site)->orderingRule,
            $account
        )->throwIfFailed();

        return $this;
    }
}
