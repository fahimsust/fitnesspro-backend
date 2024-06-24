<?php

namespace App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\OptionValuesSearchRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionValuesController extends AbstractController
{
    public function __invoke(OptionValuesSearchRequest $request, ProductOption $productOption)
    {
        $query = ProductOptionValue::query();

        if ($productOption->type()->isDateRange()) {
            $query->orderBy('start_date');
        } else {
            $query->orderBy('rank');
        }

        return response(
            $query
                ->with('custom')
                ->forOption($productOption)
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn ($subQuery) => $subQuery->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
