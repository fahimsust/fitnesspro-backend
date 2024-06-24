<?php

namespace Domain\Products\Traits;

use Domain\Products\QueryBuilders\ProductQuery;
use Domain\Products\ValueObjects\ProductQueryParameters;
use Illuminate\Database\Query\JoinClause;

trait JoinsProductSettingsTable
{
    protected function settingsJoin(
        ProductQuery           $query,
        ProductQueryParameters $params
    )
    {
        if (!$params->include_settings) {
            return;
        }

        $query->with(
            'useSiteSettings',
            fn($query) => $query->where(
                'site_id',
                ($params->site->id > 0) ? $params->site->id : 0
            ),
        );

        return $query;

//        $query->leftJoin(
//            \DB::raw('products_settings_sites ps'),
//            fn(JoinClause $join) => $join
//                ->on(
//                    'ps.product_id',
//                    '=',
//                    \DB::raw('IF(p.parent_product > 0, p.parent_product, p.id)')
//                )
//                ->when(
//                    $params->site != null,
//                    fn(JoinClause $join) => $join
//                        ->where('ps.site_id', '=', $params->site->id),
//                    fn(JoinClause $join) => $join->whereRaw('ps.site_id = 0')
//                )
//        );

//        if (!$params->site) {
//            return $query;
//        }
//
//        return $query
//            ->leftJoin(
//                \DB::raw('products_settings_sites dps'),
//                fn(JoinClause $join) => $join
//                    ->on(
//                        'dps.product_id',
//                        '=',
//                        \DB::raw('IF(p.parent_product > 0, p.parent_product, p.id)')
//                    )
//                    ->where('dps.site_id', '=', 0)
//            )
//            ->leftJoin(
//                \DB::raw('sites_settings ss'),
//                fn(JoinClause $join) => $join
//                    ->on('ss.site_id', '=', 'ps.site_id')
//            );
    }
}
