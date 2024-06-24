<?php

namespace App\Api\Admin\Elements\Controllers;

use Domain\Content\Models\Element;
use Domain\Content\QueryBuilders\ElementQuery;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ElementsController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            Element::query()
                ->when(
                    $request->filled('keyword'),
                    fn (ElementQuery $query) => $query->basicKeywordSearch($request->keyword)
                )
                ->when(
                    $request->filled('order_by'),
                    fn (ElementQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
