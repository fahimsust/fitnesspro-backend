<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Accounts\Models\Account;
use Domain\Products\Actions\Filter\Query\ApplyAvailabilityFilterToQuery;
use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;
use Support\Contracts\AbstractAction;

class BuildDetailsIntoQuery extends AbstractAction
{
    public array $select = [];

    public function __construct(
        public ProductQuery           $query,
        public ProductQueryParameters $params,
        public ?Account               $customer = null
    )
    {
    }

    public function execute(): void
    {
        if ($this->params->pricing_only) {
            return;
        }

        $this->query
            ->addSelect(
                collect([
                    'p.id',
                    'p.parent_product',
                    'p.title',
                    'p.subtitle',
                    'p.status',
                    'pd.summary',
                    'pd.description',
                    'p.default_outofstockstatus_id as availability_id',
                    'p.details_img_id',
                    'p.category_img_id',
                    'p.product_no',
                    'p.combined_stock_qty as stock_qty',
                    'p.inventoried',
                    'pp.published_date',
                    'pp.site_id',
                    'pp.min_qty',
                    'pp.max_qty',
//                    'dt.include as product_thumbnail_template_name',
//                    'dt.image_width as product_thumbnail_template_imgwidth',
//                    'dt.image_height as product_thumbnail_template_imgheight'
                ])
                    ->map(fn($field) => \DB::raw($field))
                    ->toArray()
            )
            ->when(
                $this->params->site,
                fn($query) => $query->addSelect(
                    collect([
//                        "orules.id as ordering_rule_id",
//                        "orules.name as ordering_rule_name",
                        "pd.rating",
//                        "IFNULL(ps.product_thumbnail_template, IFNULL(dps.product_thumbnail_template, ss.default_product_thumbnail_template)) as product_thumbnail_template"
                    ])
                        ->map(fn($field) => \DB::raw($field))
                        ->toArray()
                ),
                fn($query) => $query->addSelect(
                    collect([
//                        "ps.product_thumbnail_template",
                        "pd.rating"
                    ])
                        ->map(fn($field) => \DB::raw($field))
                        ->toArray()
                )
            )
            ->when(
                !$this->params->includeParentChildren->includesChildren()
                || !$this->params->include_parent,
                fn($query) => $query->addSelect([
                    'p.url_name',
                    'p.has_children as has_options'
                ])
            );

        $this->applyParentChildrenCriteria();
        $this->includeBrand();
        $this->includeImages();
        $this->includeAvailability();
        $this->includeDisplayTemplates();
    }

    protected function includeBrand(): void
    {
        if (!$this->params->include_brand) {
            return;
        }

        $this->query
            ->addSelect(\DB::raw('b.name as brand_name'))
            ->leftJoin(
                \DB::raw('brands b'),
                fn(JoinClause $join) => $join
                    ->on('pd.brand_id', '=', 'b.id')
                    ->whereRaw('pd.brand_id > 0')
            );
    }

    protected function includeImages(): void
    {
        if (!$this->params->include_images) {
            return;
        }

        $this->query
            ->with('thumbnailImage');
//        $this->query
//            ->addSelect(\DB::raw('i.filename'))
//            ->leftJoin(
//                \DB::raw('images i'),
//                fn(JoinClause $join) => $join
//                    ->on('i.id', '=', 'p.category_img_id')
//                    ->whereRaw('p.category_img_id > 0')
//            );
    }

    protected function includeAvailability(): void
    {
        ApplyAvailabilityCriteriaToQuery::now(
            query: $this->query,
            params: $this->params
        );
    }

    protected function applyParentChildrenCriteria(): void
    {
        ApplyParentsOnlyCriteriaToQuery::now(
            query: $this->query,
            params: $this->params,
            site: $this->params->site
        );
        ApplyChildrenOnlyCriteriaToQuery::now(
            query: $this->query,
            params: $this->params
        );
        ApplyParentsAndChildrenCriteriaToQuery::now(
            query: $this->query,
            params: $this->params
        );
    }

    protected function includeDisplayTemplates(): void
    {
        if (!$this->params->include_displaytemplates) {
            return;
        }

        $this->query
            ->with(
                'useSiteSettings.thumbnailTemplate',
                fn($query) => $query->where(
                    'site_id',
                    ($this->params->site->id > 0) ? $this->params->site->id : 0
                )
            );

//        $this->query->leftJoin(
//            \DB::raw('display_templates dt'),
//            fn(JoinClause $join) => $join
//                ->when(
//                    $this->params->site != null,
//                    fn(JoinClause $join) => $join
//                        ->on(
//                            'dt.id',
//                            '=',
//                            \DB::raw(
//                                'IFNULL(ps.product_thumbnail_template, IFNULL(dps.product_thumbnail_template, ss.default_product_thumbnail_template))'
//                            )
//                        )
//                        ->whereRaw('IFNULL(ps.product_thumbnail_template, IFNULL(dps.product_thumbnail_template, ss.default_product_thumbnail_template)) > 0'),
//                    fn(JoinClause $join) => $join
//                        ->on('dt.id', '=', 'ps.product_thumbnail_template')
//                        ->whereRaw('ps.product_thumbnail_template > 0')
//                )
//        );
    }
}
