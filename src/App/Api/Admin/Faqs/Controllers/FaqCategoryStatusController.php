<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqStatusRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqCategoryStatusController extends AbstractController
{
    public function __invoke(FaqCategory $faqCategory,FaqStatusRequest $request)
    {
        $faqCategory->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $faqCategory,
            Response::HTTP_CREATED
        );
    }
}
