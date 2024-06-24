<?php

namespace Domain\Products\Actions\Categories;

use App\Api\Products\Contracts\AbstractCategoryRequest;
use App\Api\Products\Enums\CategoryPageIncludes;
use App\Api\Products\Resources\CategoryResource;
use Domain\Accounts\Models\Account;
use Domain\Products\Actions\Categories\Query\BuildCategoryProductQuery;
use Domain\Products\Actions\Filter\Query\BuildAttributeValuesQueryFromProductQuery;
use Domain\Products\Actions\Filter\Query\BuildBrandsQueryFromProductQuery;
use Domain\Products\Actions\Filter\Query\BuildOptionValuesQueryFromProductQuery;
use Domain\Products\Actions\Filter\Query\BuildProductTypesQueryFromProductQuery;
use Domain\Products\Enums\IncludeParentChildrenOptions;
use Domain\Products\Models\Category\Category;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\CategoryProductQueryParameters;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class LoadCategoryByRequest extends AbstractAction
{
    private Category $category;
    private array $data;
    private ?ProductQuery $filterQuery = null;
    private ?CategoryProductQueryParameters $optionValuesParams = null;

    public function __construct(
        public AbstractCategoryRequest $request,
        public ?Site                   $site,
        public ?Account                $customer,
    )
    {
        $this->category = $this->request->loadCategory();
        $this->data = [];
    }

    public function execute(): static
    {
        if (
            $this->includes(CategoryPageIncludes::Filters)
            || $this->includes(CategoryPageIncludes::Products)
        ) {
            $filtersWithFields = LoadFiltersToDisplayForCategory::now(
                $this->category->id,
                $this->request,
                optionValues: BuildOptionValuesQueryFromProductQuery::now(
                    query: BuildCategoryProductQuery::now(
                        $this->category,
                        $this->buildParamsForOptionValues(),
                    ),
                    params: $this->buildParamsForOptionValues()
                )
//                    ->ddRawSql()
                    ->get()
                    ->groupBy('name'),
                attributeValues: BuildAttributeValuesQueryFromProductQuery::now(
                    $this->buildFilterQuery()
                )
                    ->get()
                    ->groupBy('attribute_id'),
                brands: BuildBrandsQueryFromProductQuery::now(
                    $this->buildFilterQuery()
                )->get(),
                types: BuildProductTypesQueryFromProductQuery::now(
                    $this->buildFilterQuery()
                )->get()
            );

            $this->data['filters'] = $filtersWithFields;

            if ($this->includes(CategoryPageIncludes::Products)) {
                $params = $this->buildParams();
                $params->filters = $filtersWithFields;

                $this->data['products'] = LoadProductsForCategory::now(
                    $this->category,
                    $params,
                );
            }
        }

        if ($this->includes(CategoryPageIncludes::FeaturedProducts)) {
            $params = $this->buildParams();
            $params->featuredOnly = true;

            $this->data['featured_products'] = LoadProductsForCategory::now(
                $this->category,
                $params,
            );
        }

        if ($this->includes(CategoryPageIncludes::Subcategories)) {
            $this->data['subcategories'] = CategoryResource::collection(
                LoadSubcategoriesByCategoryId::now(
                    parentCategoryId: $this->category->id,
                    activeOnly: true
                )
            );
        }

        return $this;
    }

    protected function buildFilterQuery(): ProductQuery
    {
        if ($this->filterQuery) {
            return clone $this->filterQuery;
        }

        $params = $this->buildParams()->setupForFilters();

        $this->filterQuery = BuildCategoryProductQuery::now(
            $this->category,
            $params,
        );

        return clone $this->filterQuery;
    }

    public function result(): array
    {
        if ($this->includes(CategoryPageIncludes::Category)) {
            $this->data['category'] = new CategoryResource($this->category);
        }

        return $this->data;
    }

    protected function buildParams(): CategoryProductQueryParameters
    {
        $params = CategoryProductQueryParameters::fromCategoryPageRequest(
            $this->category,
            $this->request,
        );

        $params->site = $this->site;
        $params->customer = $this->customer;

        return $params;
    }

    protected function includes(CategoryPageIncludes $include): bool
    {
        return in_array($include->value, $this->request->include);
    }

    protected function buildParamsForOptionValues(): CategoryProductQueryParameters
    {
        if ($this->optionValuesParams) {
            return $this->optionValuesParams;
        }

        $params = $this->buildParams()
            ->setupForFilters()
            ->includeParentChildrenOptions(
                IncludeParentChildrenOptions::ChildrenOnly
            );

        $params->include_details = false;

        return $this->optionValuesParams = $params;
    }
}
