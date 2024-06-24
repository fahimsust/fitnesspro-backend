<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Tests\Feature\Traits\CanSearchByKeyword;

class BrandQuery extends Builder
{
    use CanSearchByKeyword;

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'name'], $keyword);
    }
    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn () => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('category_id')) {
            $brand_ids = Category::find($request->category_id)->categoryBrands->pluck('brand_id')->toArray();
            if($brand_ids)
                $this->whereNotIn('id',$brand_ids);
        }
        return $this;

    }
}
