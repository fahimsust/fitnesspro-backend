<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryImageRequest;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryImageController extends AbstractController
{
    public function store(Category $category, CategoryImageRequest $request)
    {
        $category->update(['image_id' => $request->image_id]);

        return response(
            $category->load('image'),
            Response::HTTP_CREATED
        );
    }
}
