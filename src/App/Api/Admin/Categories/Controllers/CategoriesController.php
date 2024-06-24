<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryKeywordSearchRequest;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends AbstractController
{
    public function __invoke(CategoryKeywordSearchRequest $request)
    {
        return response(
            Category::query()
                ->search(
                   $request
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
}
