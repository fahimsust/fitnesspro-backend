<?php

namespace App\Api\Admin\Faqs\Controllers;

use Domain\Content\Models\Faqs\FaqCategory;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class FaqCategoryListController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            FaqCategory::where('status',true)->get(),
            Response::HTTP_OK
        );
    }
}
