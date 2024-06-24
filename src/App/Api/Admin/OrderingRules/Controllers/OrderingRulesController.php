<?php

namespace App\Api\Admin\OrderingRules\Controllers;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\QueryBuilders\OrderingRuleQuery;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderingRulesController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            OrderingRule::query()
                ->when(
                    $request->filled('keyword'),
                    fn (OrderingRuleQuery $query) => $query->basicKeywordSearch($request->keyword)
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->withCount('childRules','conditions')
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
