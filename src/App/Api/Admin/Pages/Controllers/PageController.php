<?php

namespace App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageRequest;
use Domain\Content\Actions\DeletePage;
use Domain\Content\Models\Pages\Page;
use Domain\Content\QueryBuilders\PageQuery;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class PageController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Page::query()
                ->when(
                    $request->filled('keyword'),
                    fn (PageQuery $query) => $query->basicKeywordSearch($request->keyword)
                )
                ->when(
                    $request->filled('order_by'),
                    fn ($query) => $query->orderBy($request->order_by,$request->order_type?$request->order_type:'asc')
                )
                ->paginate($request?->per_page),
            Response::HTTP_OK
        );
    }
    public function store(PageRequest $request)
    {
        return response(
            Page::Create([
                'title' => $request->title,
                'url_name' => $request->url_name,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function update(Page $page, PageRequest $request)
    {
        $page->update([
            'title' => $request->title,
            'url_name' => $request->url_name,
            'content' => $request->page_content,
            'notes' => $request->notes,
        ]);
        return response(
            $page->refresh(),
            Response::HTTP_CREATED
        );
    }

    public function show(Page $page)
    {
        return response(
            $page,
            Response::HTTP_OK
        );
    }

    public function destroy(Page $page)
    {
        return response(
            DeletePage::run($page),
            Response::HTTP_OK
        );
    }
}
