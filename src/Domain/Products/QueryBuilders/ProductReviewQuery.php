<?php

namespace Domain\Products\QueryBuilders;

use App\Api\Site\Reviews\Requests\ReviewsRequest;
use Domain\Products\Enums\ProductReviewItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductReviewQuery extends Builder
{

    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn() => $this->like(['name', 'comment'], $request->keyword) && false
            )->whenFilled(
                'item_id',
                fn () => $this->where('item_id', $request->item_id) && false
            );
        return $this;
    }

    public function searchByProductOrOption(ReviewsRequest $request): static
    {
        $this->where(function ($query) use ($request) {
            $query->where('item_id', $request->product_id)
                ->where('item_type', ProductReviewItem::PRODUCT);
        })->orWhere(function ($query) use ($request) {
            $query->where('item_id', $request->option_id)
                ->where('item_type', ProductReviewItem::ATTRIBUTE);
        });
        return $this;
    }
}
