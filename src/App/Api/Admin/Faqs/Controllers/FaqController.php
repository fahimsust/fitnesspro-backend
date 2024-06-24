<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqRequest;
use Domain\Content\Models\Faqs\Faq;
use Domain\Content\QueryBuilders\FaqQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class FaqController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Faq::query()
                ->when(
                    $request->filled('keyword'),
                    fn (FaqQuery $query) => $query->basicKeywordSearch($request->keyword)
                )
                ->when(
                    $request->filled('order_by'),
                    fn (FaqQuery $query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(FaqRequest $request)
    {
        $faq = Faq::Create([
            'question' => $request->question,
            'url' => $request->url,
            'answer' => $request->answer,
            'status' => $request->status,
            'rank' => $request->rank
        ]);
        foreach($request->categories_id as $category_id)
        {
            $faq->faq_categories()->create(
                [
                    'categories_id' => $category_id,
                ]
            );
        }
        return response(
            $faq,
            Response::HTTP_CREATED
        );
    }

    public function update(Faq $faq, FaqRequest $request)
    {
        $faq->faq_categories()->delete();
        foreach($request->categories_id as $category_id)
        {
            $faq->faq_categories()->create(
                [
                    'categories_id' => $category_id,
                ]
            );
        }
        return response(
            $faq->update([
                'question' => $request->question,
                'url' => $request->url,
                'answer' => $request->answer,
                'status' => $request->status,
                'rank' => $request->rank
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(Faq $faq)
    {
        return response(
            Faq::with('faq_categories')->find($faq->id),
            Response::HTTP_OK
        );
    }

    public function destroy(Faq $faq)
    {
        return response(
            $faq->delete(),
            Response::HTTP_OK
        );
    }
}
