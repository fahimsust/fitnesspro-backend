<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Actions\Categories\CreateCategory;
use Domain\Products\Actions\Categories\DeleteCategory;
use Domain\Products\Actions\Categories\UpdateCategory;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function index()
    {
        return response(
            Category::orderBy('title')->select('id', 'title')->get(),
            Response::HTTP_OK
        );
    }

    public function store(CreateCategoryRequest $request)
    {
        return response(
            CreateCategory::run($request),
            Response::HTTP_CREATED
        );
    }

    public function update(Category $category, CreateCategoryRequest $request)
    {
        return response(
            UpdateCategory::run($category, $request),
            Response::HTTP_CREATED
        );
    }

    public function show(Category $category)
    {
        return response(
            $category->load('image'),
            Response::HTTP_OK
        );
    }

    public function destroy(Category $category)
    {
        return response(
            DeleteCategory::run($category),
            Response::HTTP_OK
        );
    }
}
