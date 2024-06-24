<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryTranslationRequest;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryTranslationController extends AbstractController
{
    public function update(Category $category,int $language_id, CategoryTranslationRequest $request)
    {
        return response(
            $category->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'url_name' => $request->url_name,
                'description' => $request->description,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $category_id,int $language_id)
    {
        return response(
            CategoryTranslation::where('category_id',$category_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
