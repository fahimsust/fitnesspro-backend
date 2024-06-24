<?php

namespace Domain\Discounts\Actions;

use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadDiscountByIdFromCache extends AbstractAction
{
    public function __construct(
        public int  $discountId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Discount
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'discount-cache.' . $this->discountId,
        ])
            ->remember(
                'load-discount-by-id.' . $this->discountId,
                60 * 10,
                fn() => $this->load()
            );
    }

    public function load(): Discount|Model
    {
        return Discount::find($this->discountId)
            ?? throw new ModelNotFoundException(
                __("No discount matching discount ID {$this->discountId}.")
            );
    }
}
