<?php

namespace Domain\Products\QueryBuilders;

use App\Api\Admin\Products\Requests\ProductImageSearchRequest;
use Illuminate\Database\Eloquent\Builder;

class ProductImageQuery extends Builder
{
    public function basicKeywordSearch(?string $keyword = null): static
    {
        $this->like(['id', 'caption'], $keyword);
        return $this;
    }
    public function search(ProductImageSearchRequest $request): static
    {
        $this
            ->where('product_id',$request->product_id);
            if($request->filled('keyword'))
            {
                $this->where(function($q) use ($request) {
                    $q->basicKeywordSearch($request->keyword);
                    $q->orwhereHas(
                        'image',
                        fn (Builder $query)=>$query->like(['default_caption','name'],$request->keyword)
                    );
                });
            }
        return $this;
    }
}
