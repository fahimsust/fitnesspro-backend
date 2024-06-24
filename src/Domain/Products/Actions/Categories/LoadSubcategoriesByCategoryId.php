<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Models\Category\Category;
use Domain\Products\QueryBuilders\CategoryQuery;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadSubcategoriesByCategoryId extends AbstractAction
{
    public function __construct(
        public int  $parentCategoryId,
        public bool $activeOnly = false
    )
    {
    }

    public function execute(): Collection
    {
        return Cache::tags([
            "category-cache.{$this->parentCategoryId}"
        ])
            ->remember(
                'load-subcategories-by-id.'
                . $this->parentCategoryId . '.'
                . ($this->activeOnly ? 'active-only' : 'all'),
                60 * 10,
                fn() => $this->filterSortQuery(
                    Category::where('parent_id', $this->parentCategoryId)
                        ->with([
                            'subcategories' => $this->filterSortQuery(...)
                        ])
                )
                    ->get()
            );
    }

    protected function filterSortQuery($query)
    {
        return $query
            ->when(
                $this->activeOnly,
                fn($query) => $query->where('status', true)
            )
            ->orderBy('rank', 'desc')
            ->orderBy('title');
    }
}
