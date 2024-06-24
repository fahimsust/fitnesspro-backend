<?php

namespace Domain\Products\Actions\Categories;

use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Filters\FilterCategory;
use Domain\Products\ValueObjects\FilterWithFields;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadFiltersToDisplayForCategory extends AbstractAction
{
    public function __construct(
        public int        $categoryId,
        public Request    $request,
        public Collection $optionValues,
        public Collection $attributeValues,
        public Collection $brands,
        public Collection $types
    )
    {
    }

    public function execute(): Collection
    {
        return Cache::tags([
            "category-cache.{$this->categoryId}"
        ])
            ->remember(
                'load-filters-for-category.'
                . $this->categoryId,
                60 * 10,
                fn() => $this->buildFilters()
            );
    }

    protected function buildFilters(): Collection
    {
        return Filter::query()
            ->fromRaw(Filter::Table() . ' as f')
            ->join(
                \DB::raw(FilterCategory::Table() . ' as fc'),
                fn($join) => $join
                    ->on(
                        'fc.filter_id',
                        '=',
                        'f.id',
                    )
                    ->whereRaw('fc.category_id = ?', $this->categoryId)
            )
            ->where('show_in_search', true)
            ->where('status', true)
            ->orderBy('rank', 'asc')
            ->get()
            ->map(
                fn(Filter $filter) => new FilterWithFields(
                    $filter,
                    collect(
                        $filter->type->buildFilterFieldsForDisplayAction(
                            filter: $filter,
                            request: $this->request,
                            optionValues: $this->optionValues,
                            attributeValues: $this->attributeValues,
                            brands: $this->brands,
                            types: $this->types
                        )->execute()
                    )
                )
            );
    }
}
