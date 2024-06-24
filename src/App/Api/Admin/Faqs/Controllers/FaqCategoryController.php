<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqCategoryRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\QueryBuilders\FaqCategoryQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class FaqCategoryController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            FaqCategory::query()
                ->search($request)
                ->when(
                    $request->filled('order_by'),
                    fn (FaqCategoryQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(FaqCategoryRequest $request)
    {
        return response(
            FaqCategory::Create([
                'title' => $request->title,
                'url' => $request->url,
                'status' => $request->status,
                'rank' => $request->rank
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(FaqCategory $faq_category, FaqCategoryRequest $request)
    {
        return response(
            $faq_category->update([
                'title' => $request->title,
                'url' => $request->url,
                'status' => $request->status,
                'rank' => $request->rank
            ]),
            Response::HTTP_CREATED
        );
    }
    public function show(FaqCategory $faqCategory)
    {
        return response(
            $faqCategory,
            Response::HTTP_OK
        );
    }
    public function destroy(FaqCategory $faq_category)
    {
        $faq_category->faq_categories()->delete();
        return response(
            $faq_category->delete(),
            Response::HTTP_OK
        );
    }
}
