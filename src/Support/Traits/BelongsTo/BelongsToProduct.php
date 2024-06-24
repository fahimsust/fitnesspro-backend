<?php

namespace Support\Traits\BelongsTo;

use Domain\Products\Actions\Product\LoadProductByIdFromCache;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToProduct
{
    private Product $productCached;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productCached(): ?Product
    {
        if (!$this->product_id) {
            return null;
        }

        if ($this->relationLoaded('product')) {
            return $this->product;
        }

        return $this->productCached ??= LoadProductByIdFromCache::now($this->product_id);
    }
}
