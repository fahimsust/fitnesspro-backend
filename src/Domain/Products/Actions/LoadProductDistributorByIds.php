<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Product\ProductDistributor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductDistributorByIds extends AbstractAction
{
    public function __construct(
        public int  $productId,
        public int  $distributorId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): ?ProductDistributor
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'product-distributor-id-cache.'
            . $this->distributorId
            . '.' . $this->productId,
        ])
            ->remember(
                'load-product-distributor-by-id.'
                . $this->distributorId
                . '.' . $this->productId,
                60 * 10,
                fn() => $this->load()
            );
    }

    public function load(): ProductDistributor|Model|null
    {
        return ProductDistributor::query()
            ->where(
                'product_id',
                $this->productId
            )
            ->where(
                'distributor_id',
                $this->distributorId
            )
            ->first();
    }
}
