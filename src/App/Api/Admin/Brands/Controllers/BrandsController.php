<?php

namespace App\Api\Admin\Brands\Controllers;

use Domain\Products\Models\Brand;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BrandsController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            Brand::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
