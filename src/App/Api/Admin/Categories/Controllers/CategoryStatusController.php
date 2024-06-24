<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryStatusRequest;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryStatusController extends AbstractController
{
    public function store(Category $category, CategoryStatusRequest $request)
    {
        $category->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $category,
            Response::HTTP_CREATED
        );
    }
}
