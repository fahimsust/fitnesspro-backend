<?php

namespace Domain\Products\QueryBuilders;

use App\Api\Admin\Categories\Requests\CategoryParentSearchRequest;
use Domain\Sites\Models\SiteCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryQuery extends Builder
{
    public function whereSlug(string $slug): static
    {
        return $this->where('url_name', $this->slug);
    }

    public function availableToAssignAsParent(CategoryParentSearchRequest $request)
    {
        $request
            ->whenFilled(
                'keyword',
                fn() => $this->basicKeywordSearch($request->keyword) && false
            )
            ->whenFilled(
                'category_id',
                fn() => $this->where('id', '!=', $request->category_id) && false,
            );
        return $this;
    }

    public function basicKeywordSearch(string $keyword)
    {
        return $this->like(['id', 'title', 'url_name'], $keyword);
    }

    public function search(Request $request): static
    {
        $request
            ->whenFilled(
                'keyword',
                fn() => $this->basicKeywordSearch($request->keyword) && false
            );
        if ($request->filled('site_id')) {
            $category_ids = SiteCategory::whereSiteId($request->site_id)->pluck('category_id')->toArray();
            if ($category_ids)
                $this->whereNotIn('id', $category_ids);
        }
        return $this;
    }
}
