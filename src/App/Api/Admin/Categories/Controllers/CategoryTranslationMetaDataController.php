<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryTranslationMetaDataRequest;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryTranslationMetaDataController extends AbstractController
{
    public function update(Category $category,int $language_id,  CategoryTranslationMetaDataRequest $request)
    {
        return response(
            $category->translations()->updateOrCreate(
                [
                    'language_id'=>$language_id
                ],
                [
                    'meta_title' => $request->meta_title,
                    'meta_desc' => $request->meta_desc,
                    'meta_keywords' => $request->meta_keywords,
                ]),
            Response::HTTP_CREATED
        );
    }
}
