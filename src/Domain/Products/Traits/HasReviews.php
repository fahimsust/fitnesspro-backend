<?php

namespace Domain\Products\Traits;

use Domain\Products\Models\Product\ProductReview;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReviews
{
    public function reviews(): MorphMany
    {
        return $this->morphMany(ProductReview::class, 'item');
    }
}
