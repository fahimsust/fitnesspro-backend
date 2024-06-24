<?php

namespace Domain\Products\Actions\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteOrderingRule
{
    use AsObject;

    public function handle(
        OrderingRule $orderingRule
    ): bool {
        if ($orderingRule->pricing()->exists()) {
            throw new \Exception(__(
                "Can't delete: there are products using this rule. Update these products before deleting: :products",
                [
                    'products' => $orderingRule->pricing()
                        ->with('product')
                        ->get()
                        ->pluck('product')
                        ->collapse()
                        ->pluck('title')
                        ->implode(', '),
                ]
            ));
        }

        if ($orderingRule->childRules()->exists()) {
            throw new \Exception(__(
                "Can't delete: there are child rules using this rule. Update these child rules before deleting: :rules",
                [
                    'rules' => $orderingRule->childRules()
                        ->pluck('name')
                        ->implode(', '),
                ]
            ));
        }
        $orderingRule->delete();

        return true;
    }
}
