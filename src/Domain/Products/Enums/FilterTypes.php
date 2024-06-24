<?php

namespace Domain\Products\Enums;

use Domain\Products\Actions\Filter\Display\BuildAttributeFilterFieldsForDisplay;
use Domain\Products\Actions\Filter\Display\BuildAvailabilityFilterFieldForDisplay;
use Domain\Products\Actions\Filter\Display\BuildBrandFilterFieldForDisplay;
use Domain\Products\Actions\Filter\Display\BuildOptionFilterFieldsForDisplay;
use Domain\Products\Actions\Filter\Display\BuildPriceFilterFieldForDisplay;
use Domain\Products\Actions\Filter\Display\BuildTypeFilterFieldForDisplay;
use Domain\Products\Actions\Filter\Query\ApplyAttributeFilterToQuery;
use Domain\Products\Actions\Filter\Query\ApplyAvailabilityFilterToQuery;
use Domain\Products\Actions\Filter\Query\ApplyBrandFilterToQuery;
use Domain\Products\Actions\Filter\Query\ApplyOptionFilterToQuery;
use Domain\Products\Actions\Filter\Query\ApplyPriceFilterToQuery;
use Domain\Products\Actions\Filter\Query\ApplyTypeFilterToQuery;
use Domain\Products\Contracts\ApplyFilterToQueryAction;
use Domain\Products\Contracts\BuildFilterFieldForDisplayAction;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

enum FilterTypes: int
{
    case Price = 1;
    case Attribute = 2;
    case Brand = 3;
    case Type = 4;
    case Option = 5;
    case SecondaryAttribute = 6;
    case Availability = 0;

    public function buildFilterFieldsForDisplayAction(
        Filter     $filter,
        Request    $request,
        Collection $optionValues,
        Collection $attributeValues,
        Collection $brands,
        Collection $types,
    ): BuildFilterFieldForDisplayAction
    {
        return match($this){
            self::Availability => new BuildAvailabilityFilterFieldForDisplay(
                filter: $filter,
                request: $request,
            ),
            self::Option => new BuildOptionFilterFieldsForDisplay(
                filter: $filter,
                request: $request,
                optionValues: $optionValues
            ),
            self::Type => new BuildTypeFilterFieldForDisplay(
                filter: $filter,
                request: $request,
                types: $types
            ),
            self::Brand => new BuildBrandFilterFieldForDisplay(
                filter: $filter,
                request: $request,
                brands: $brands
            ),
            self::Attribute,
            self::SecondaryAttribute => new BuildAttributeFilterFieldsForDisplay(
                filter: $filter,
                request: $request,
                attributeValues: $attributeValues
            ),
            self::Price => new BuildPriceFilterFieldForDisplay(
                filter: $filter,
                request: $request,
            ),
        };
    }

    public function applyToQueryAction(
        ProductQuery           $query,
        ProductQueryParameters $params,
        Filter                 $filter,
        mixed                  $field,
    ): ApplyFilterToQueryAction
    {
        return match ($this) {
            self::Availability => new ApplyAvailabilityFilterToQuery(
                query: $query,
                params: $params,
            ),
            self::Option => new ApplyOptionFilterToQuery(
                query: $query,
                params: $params,
                filter: $filter,
                field: $field
            ),
            self::Type => new ApplyTypeFilterToQuery(
                query: $query,
                field: $field
            ),
            self::Brand => new ApplyBrandFilterToQuery(
                query: $query,
                field: $field
            ),
            self::Attribute,
            self::SecondaryAttribute => new ApplyAttributeFilterToQuery(
                query: $query,
                field: $field
            ),
            self::Price => new ApplyPriceFilterToQuery(
                query: $query,
                params: $params,
                filter: $filter,
                field: $field
            ),
        };
    }
}
