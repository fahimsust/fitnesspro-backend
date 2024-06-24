<?php

namespace Domain\Products\Actions\Distributors;

use Domain\Products\Models\Product\ProductDistributor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadProductDistributorWithDistributor extends AbstractAction
{
    public function __construct(
        public int  $productId,
        public int  $distributorId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): ProductDistributor
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'product-distributor-product-id-cache.' . $this->productId,
            'product-distributor-distributor-id-cache.' . $this->distributorId,
        ])
            ->remember(
                'load-product-distributor-with-distributor.'
                . $this->productId
                . '.' . $this->distributorId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): ProductDistributor|Model
    {
        return ProductDistributor::with('distributor')
            ->where('product_id', $this->productId)
            ->where('distributor_id', $this->distributorId)
            ->first()
            ?? throw new ModelNotFoundException(
                __("No product distributor matching product ID {$this->productId} and distributor ID {$this->distributorId}.")
            );
    }
}
