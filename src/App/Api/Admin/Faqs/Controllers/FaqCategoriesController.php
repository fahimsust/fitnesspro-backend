<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqCategoresRequest;
use Domain\Content\Actions\AssignCategoryToFaq;
use Domain\Content\Actions\RemoveCategoryFromFaq;
use Domain\Content\Models\Faqs\Faq;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqCategoriesController extends AbstractController
{
    public function index(Faq $faq)
    {
        return response(
            $faq->categories,
            Response::HTTP_OK
        );
    }

    public function store(Faq $faq, FaqCategoresRequest $request)
    {
        return response(
            AssignCategoryToFaq::run($faq, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Faq $faq, int $categoryId)
    {
        return response(
            RemoveCategoryFromFaq::run($faq, $categoryId),
            Response::HTTP_OK
        );
    }
}
