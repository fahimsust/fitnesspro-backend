<?php

namespace Domain\Products\ValueObjects;

use App\Api\Products\Contracts\AbstractProductsQueryRequest;
use Domain\Accounts\Models\Account;
use Domain\Products\Enums\IncludeParentChildrenOptions;
use Domain\Sites\Models\Site;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class ProductQueryParameters extends Data
{
    public ?Account $customer = null;
    public ?Site $site = null;
    public IncludeParentChildrenOptions $includeParentChildren = IncludeParentChildrenOptions::ParentsOnly;
    public bool $pricing_only = false;

    public bool $include_images = true;
    public bool $include_displaytemplates = true;
    public bool $include_settings = true;
    public bool $include_details = true;
    public bool $include_parent = true;
    public bool $include_brand = true;
    public bool $ignore_availability = false;
    public bool $ignore_inventory_rules = false;
    public bool $is_filter = false;
    public string $orderby = "";
    public bool $filter_status = true;
    public int $filter_status_value = 1;
    public string $filter_status_compare = '=';
    public bool $filter_pricing_status = true;
    public string $filter_pricing_status_compare = '=';
    public int $filter_pricing_status_value = 1;
    public Collection $filters;

    public int $page = 1;
    public int $perPage = 20;

    public bool $search = false;
    public ?string $searchKeyword = null;
    public array $searchArray = [];
    public array $searchAttributes = [];
    public array $searchTypes = [];
    public ?Carbon $searchDate = null;

    public function __construct()
    {
        $this->filters = collect();
    }

    public static function fromRequest(
        AbstractProductsQueryRequest $request,
    ): static
    {
        return static::from(
            static::standardFromRequest($request)
        );
    }

    protected static function standardFromRequest(
        AbstractProductsQueryRequest $request
    ): array
    {
        return [
            'page' => $request->input('page', 1),
            'perPage' => $request->input('per_page', 20),
            'search' => $request->has('keyword') || $request->has('search_array'),
            'searchKeyword' => $request->input('keyword', null),
            'searchArray' => $request->input('search_array', []),
            'searchAttributes' => $request->input('search_attributes', []),
            'searchTypes' => $request->input('search_types', []),
            'searchDate' => $request->has('search_date')
                ? Carbon::parse($request->input('search_date'))
                : null,
        ];
    }

    public function setupForFilters(): static
    {
        $this->is_filter = true;
        $this->include_images = false;
        $this->include_displaytemplates = false;
        $this->include_settings = false;
        $this->include_brand = false;

        return $this;
    }

    public function removeExtras(): static
    {
        $this->include_images = false;
        $this->include_parent = false;
        $this->include_displaytemplates = false;
        $this->include_brand = false;
        $this->include_settings = false;
        $this->include_details = false;

        return $this;
    }

    public function includeParentChildrenOptions(
        IncludeParentChildrenOptions $includeParentChildren
    ): static
    {
        $this->includeParentChildren = $includeParentChildren;

        return $this;
    }

    public function cacheKey(): string
    {
        return md5(serialize($this->toArray()));
    }
}
